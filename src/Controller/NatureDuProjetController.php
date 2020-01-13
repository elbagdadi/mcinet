<?php

namespace App\Controller;

use App\Entity\NatureDuProjet;
use App\Form\NatureDuProjetType;
use App\Repository\NatureDuProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/natureduprojet")
 */
class NatureDuProjetController extends AbstractController
{
    /**
     * @Route("/", name="nature_du_projet_index", methods={"GET"})
     */
    public function index(NatureDuProjetRepository $natureDuProjetRepository): Response
    {
        return $this->render('nature_du_projet/index.html.twig', [
            'nature_du_projets' => $natureDuProjetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nature_du_projet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $natureDuProjet = new NatureDuProjet();
        $form = $this->createForm(NatureDuProjetType::class, $natureDuProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($natureDuProjet);
            $entityManager->flush();

            return $this->redirectToRoute('nature_du_projet_index');
        }

        return $this->render('nature_du_projet/new.html.twig', [
            'nature_du_projet' => $natureDuProjet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nature_du_projet_show", methods={"GET"})
     */
    public function show(NatureDuProjet $natureDuProjet): Response
    {
        return $this->render('nature_du_projet/show.html.twig', [
            'nature_du_projet' => $natureDuProjet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nature_du_projet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NatureDuProjet $natureDuProjet): Response
    {
        $form = $this->createForm(NatureDuProjetType::class, $natureDuProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nature_du_projet_index');
        }

        return $this->render('nature_du_projet/edit.html.twig', [
            'nature_du_projet' => $natureDuProjet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nature_du_projet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NatureDuProjet $natureDuProjet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$natureDuProjet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($natureDuProjet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nature_du_projet_index');
    }
}
