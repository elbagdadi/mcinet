<?php

namespace App\Controller;

use App\Entity\DetailsEstimation;
use App\Form\DetailsEstimationType;
use App\Repository\DetailsEstimationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/details")
 */
class DetailsEstimationController extends AbstractController
{
    /**
     * @Route("/", name="details_estimation_index", methods={"GET"})
     */
    public function index(DetailsEstimationRepository $detailsEstimationRepository): Response
    {
        return $this->render('details_estimation/index.html.twig', [
            'details_estimations' => $detailsEstimationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/api/estimation/{estimation}", name="details_estimation_by_estimation", methods={"GET"})
     */
    public function getDetails(Request $request,DetailsEstimationRepository $detailsEstimationRepository): Response
    {
        $estimation = $request->get('estimation');
        $details = $detailsEstimationRepository->findByEstimation($estimation);
        return $this->json([
            'result' => true,
            'details'=> $details
        ]);
    }
    /**
     * @Route("/new", name="details_estimation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailsEstimation = new DetailsEstimation();
        $form = $this->createForm(DetailsEstimationType::class, $detailsEstimation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailsEstimation);
            $entityManager->flush();

            return $this->redirectToRoute('details_estimation_index');
        }

        return $this->render('details_estimation/new.html.twig', [
            'details_estimation' => $detailsEstimation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="details_estimation_show", methods={"GET"})
     */
    public function show(DetailsEstimation $detailsEstimation): Response
    {
        return $this->render('details_estimation/show.html.twig', [
            'details_estimation' => $detailsEstimation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="details_estimation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailsEstimation $detailsEstimation): Response
    {
        $form = $this->createForm(DetailsEstimationType::class, $detailsEstimation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('details_estimation_index');
        }

        return $this->render('details_estimation/edit.html.twig', [
            'details_estimation' => $detailsEstimation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="details_estimation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DetailsEstimation $detailsEstimation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailsEstimation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailsEstimation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('details_estimation_index');
    }

}
