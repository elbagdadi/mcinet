<?php

namespace App\Controller;

use App\Entity\FuturInvestisseur;
use App\Form\FuturInvestisseurType;
use App\Repository\FuturInvestisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/investisseur")
 */
class FuturInvestisseurController extends AbstractController
{
    /**
     * @Route("/", name="futur_investisseur_index", methods={"GET"})
     */
    public function index(FuturInvestisseurRepository $futurInvestisseurRepository): Response
    {
        return $this->render('futur_investisseur/index.html.twig', [
            'futur_investisseurs' => $futurInvestisseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="futur_investisseur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $futurInvestisseur = new FuturInvestisseur();
        $form = $this->createForm(FuturInvestisseurType::class, $futurInvestisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($futurInvestisseur);
            $entityManager->flush();

            return $this->redirectToRoute('futur_investisseur_index');
        }

        return $this->render('futur_investisseur/new.html.twig', [
            'futur_investisseur' => $futurInvestisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="futur_investisseur_show", methods={"GET"})
     */
    public function show(FuturInvestisseur $futurInvestisseur): Response
    {
        return $this->render('futur_investisseur/show.html.twig', [
            'futur_investisseur' => $futurInvestisseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="futur_investisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FuturInvestisseur $futurInvestisseur): Response
    {
        $form = $this->createForm(FuturInvestisseurType::class, $futurInvestisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('futur_investisseur_index');
        }

        return $this->render('futur_investisseur/edit.html.twig', [
            'futur_investisseur' => $futurInvestisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="futur_investisseur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FuturInvestisseur $futurInvestisseur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$futurInvestisseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($futurInvestisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('futur_investisseur_index');
    }
}
