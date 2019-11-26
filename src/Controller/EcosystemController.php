<?php

namespace App\Controller;

use App\Entity\Ecosystem;
use App\Form\EcosystemType;
use App\Repository\EcosystemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ecosystem")
 */
class EcosystemController extends AbstractController
{
    /**
     * @Route("/", name="ecosystem_index", methods={"GET"})
     */
    public function index(EcosystemRepository $ecosystemRepository): Response
    {
        return $this->render('ecosystem/index.html.twig', [
            'ecosystems' => $ecosystemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/items/api/{secteur}", name="items_api", methods={"GET"})
     */
    public function itemsApi(EcosystemRepository $ecosystemRepository,Request $request)
    {
        $data = array();
        $secteur=$request->get('secteur');
        $items = $ecosystemRepository->findBySecteur($secteur);
        foreach ($items as $key => $item){
            $data[$key]['ecosystem'] = $item->getNomEcosystem();
            $data[$key]['slug'] = $item->getSlugEcosystem();
            $data[$key]['id'] = $item->getId();
        }

        return $this->json([
            'id_field' => 'ecosystem_items',
            'items'=> $data
        ]);

    }
    /**
     * @Route("/new", name="ecosystem_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ecosystem = new Ecosystem();
        $form = $this->createForm(EcosystemType::class, $ecosystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ecosystem);
            $entityManager->flush();

            return $this->redirectToRoute('ecosystem_index');
        }

        return $this->render('ecosystem/new.html.twig', [
            'ecosystem' => $ecosystem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ecosystem_show", methods={"GET"})
     */
    public function show(Ecosystem $ecosystem): Response
    {
        return $this->render('ecosystem/show.html.twig', [
            'ecosystem' => $ecosystem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ecosystem_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ecosystem $ecosystem): Response
    {
        $form = $this->createForm(EcosystemType::class, $ecosystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ecosystem_index');
        }

        return $this->render('ecosystem/edit.html.twig', [
            'ecosystem' => $ecosystem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ecosystem_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ecosystem $ecosystem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ecosystem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ecosystem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ecosystem_index');
    }
}
