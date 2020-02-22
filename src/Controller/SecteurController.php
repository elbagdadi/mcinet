<?php

namespace App\Controller;

use App\Entity\Secteur;
use App\Form\SecteurType;
use App\Repository\MetierRepository;
use App\Repository\SecteurRepository;
use App\Repository\HasFieldRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secteur")
 */
class SecteurController extends AbstractController
{
    /**
     * @Route("/", name="secteur_index", methods={"GET"})
     */
    public function index(SecteurRepository $secteurRepository): Response
    {
        return $this->render('secteur/index.html.twig', [
            'secteurs' => $secteurRepository->findAll(),
        ]);
    }
    /**
     * @Route("/api", name="secteur_api", methods={"GET"})
     */
   public function secteurApi(SecteurRepository $secteurRepository): Response
    {
       

        $data = array();
        $parents = $secteurRepository->findbyParent();
        foreach ($parents as $key => $p){
            $data[$key]['text'] = $p->getNomSecteur();
            $data[$key]['slug'] = $p->getSlugSecteur();
            $data[$key]['id'] = $p->getId();
        }

        return $this->json([
            'id_field' => 'secteur_items',
            'items' => $data,
        ]);
    }
    /**
     * @Route("/api/all", name="secteur_api_all", methods={"GET"})
     */
    public function secteursApi(SecteurRepository $secteurRepository): Response
    {

        $data = array();
        $parents = $secteurRepository->findAll();
        foreach ($parents as $key => $p){
            $data[$key]['text'] = $p->getNomSecteur();
            $data[$key]['slug'] = $p->getSlugSecteur();
            $data[$key]['id'] = $p->getId();
        }

        return $this->json([
            'secteurs' => $data,
        ]);
    }
    /**
     * @Route("/children/api/{secteur_parent}", name="secteur_children_api", methods={"GET"})
     */
    public function childrenApi(SecteurRepository $secteurRepository,HasFieldRepository $hasFieldRepository,MetierRepository $metierRepository,Request $request)
    {
        $data = array();
        $parent=$request->get('secteur_parent');
        $children = $secteurRepository->findChild($parent);

        foreach ($children as $key => $c){
            $data[$key]['text'] = $c->getNomSecteur();
            $data[$key]['slug'] = $c->getSlugSecteur();
            $data[$key]['id'] = $c->getId();
            $data[$key]['federation'] = $c->getFederation();
            $data[$key]['fields'] = $this->getFields( $hasFieldRepository,$c->getId());
            $data[$key]['metiers'] = $this->getMetiers( $metierRepository,$c->getId());
        }

       return $this->json([
            'id_field' => 'secteur_children',
            'subs' => $data
        ]);

    }

    /**
     * @Route("/new", name="secteur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $secteur = new Secteur();
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($secteur);
            $entityManager->flush();

            return $this->redirectToRoute('secteur_index');
        }

        return $this->render('secteur/new.html.twig', [
            'secteur' => $secteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secteur_show", methods={"GET"})
     */
    public function show(Secteur $secteur): Response
    {
        return $this->render('secteur/show.html.twig', [
            'secteur' => $secteur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="secteur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Secteur $secteur): Response
    {
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secteur_index');
        }

        return $this->render('secteur/edit.html.twig', [
            'secteur' => $secteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="secteur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Secteur $secteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($secteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secteur_index');
    }
    //function
    public function getFields(HasFieldRepository $hasFieldRepository,$secteur){
        $items = $hasFieldRepository->findBySecteur($secteur);
        $data = array();
        foreach ($items as $key => $item){
            $data[$key]['field_label'] = $item->getFieldLabel();
            $data[$key]['field_type'] = $item->getFieldType();
            $data[$key]['true_value'] = $item->getTrueValue();
            $data[$key]['field_option'] = $item->getOptions();
            $data[$key]['selector_id'] = $item->getSelectorId();
            $data[$key]['selector_classes'] = $item->getSelectorClasses();
            $data[$key]['selector_placeholder'] = $item->getSelectorPlaceholder();
            $data[$key]['id'] = $item->getId();
        }
        return $data;
    }
    public function getMetiers(MetierRepository $metierRepository,$secteur){
            $metiers = $metierRepository->findBySecteur($secteur);
            $data = array();
            foreach ($metiers as $key => $metier){
                $data[$key]['id'] = $metier->getId();
                $data[$key]['metier'] = $metier->getNomMetier();
            }
            return $data;
    }
}
