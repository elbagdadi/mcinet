<?php

namespace App\Controller;

use App\Entity\Estimation;
use App\Entity\DetailsEstimation;
use App\Entity\Secteur;
use App\Form\EstimationType;
use App\Repository\EstimationRepository;
use App\Repository\SecteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/estimation")
 */
class EstimationController extends AbstractController
{
    /**
     * @Route("/", name="estimation_index", methods={"GET"})
     */
    public function index(EstimationRepository $estimationRepository): Response
    {
        return $this->render('estimation/index.html.twig', [
            'estimations' => $estimationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/api/new", name="estimation_api_new", methods={"POST"})
     */
    public function api_new(Request $request): Response
    {
        $estimation = new Estimation();
        $secteur = $request->request->get("secteur");
        $ecosystem = $request->request->get("ecosystem");
        $date_estimation = date("d-m-Y H:i:s");
        $user = $request->request->get("user");
        $details = json_decode($request->request->get("details"),true);




        if ($secteur != '' && $user != '') {
            $estimation->setSecteur($secteur);
            $estimation->setDateEstimation($date_estimation);
            $estimation->setEcosystem($ecosystem);
            $estimation->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estimation);
            $entityManager->flush();
            if($estimation->getId()){
                $estimationId = $estimation->getId();

                $exluded_keys = array('offshoring_rbi','offshoring_is_ir','villes');
               foreach ($details as $key => $value){

                      /* $detailsEstimation->setCle($key);
                       $detailsEstimation->setValeur($value[0]);
                       $detailsEstimation->setEstimation($estimationId);
                       $entityManager->persist($detailsEstimation);
                       $entityManager->flush();*/


                      if (!in_array($key,$exluded_keys) && $value != 0 ){

                          $detailsEstimation = new DetailsEstimation();
                          $detailsEstimation->setCle($key);
                          $detailsEstimation->setValeur(strval($value));
                          $detailsEstimation->setEstimation($estimationId);
                          $entityManager->persist($detailsEstimation);
                          $entityManager->flush();
                      }


                }

                return $this->json(['details' => $details]);
            }
        }


    }
    /**
     * @Route("/api/all", name="estimation_api_all", methods={"GET"})
     */
    public function allSimulations(EstimationRepository $estimationRepository){
        $simulations = $estimationRepository->findAll();
        return $this->json(['history' => $simulations]);

    }
    /**
     * @Route("/api/allpaginated/{page}", name="estimation_api_all_paginated", methods={"GET"})
     */
    public function allSimulationsPaginated($page = 1,EstimationRepository $estimationRepository,Request $request, PaginatorInterface $paginator){
        $data = $estimationRepository->findAll();
        $page = intval($request->get('page',1));
        $simulations = $paginator->paginate(
            $data,
            $page,
            8
        );
        return $this->json(['history' => $simulations,'count' => count($data)]);

    }
    /**
     * @Route("/api/by/{user}", name="estimation_api_getby", methods={"GET"})
     */
    public function getByUser(EstimationRepository $estimationRepository,SecteurRepository $secteurRepository,Request $request): Response
    {
        $user = $request->get('user');
        $history = $estimationRepository->findByUser($user);
        return $this->json(['history' => $history]);
    }
    /**
     * @Route("/new", name="estimation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $estimation = new Estimation();
        $form = $this->createForm(EstimationType::class, $estimation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estimation);
            $entityManager->flush();

            return $this->redirectToRoute('estimation_index');
        }

        return $this->render('estimation/new.html.twig', [
            'estimation' => $estimation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estimation_show", methods={"GET"})
     */
    public function show(Estimation $estimation): Response
    {
        return $this->render('estimation/show.html.twig', [
            'estimation' => $estimation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estimation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Estimation $estimation): Response
    {
        $form = $this->createForm(EstimationType::class, $estimation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estimation_index');
        }

        return $this->render('estimation/edit.html.twig', [
            'estimation' => $estimation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estimation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Estimation $estimation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estimation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($estimation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('estimation_index');
    }
}
