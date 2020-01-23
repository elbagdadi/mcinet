<?php

namespace App\Controller;

use App\Entity\FuturInvestisseur;
use App\Form\FuturInvestisseurType;
use App\Repository\FuturInvestisseurRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     * @Route("/profile/{user_id}", name="futur_investisseur_information", methods={"GET"})
     */
    public function informations(FuturInvestisseurRepository $futurInvestisseurRepository,UserRepository $userRepository, Request $request): Response
    {
        $result = [];
        $user_id = $request->get('user_id');
        $loggedInUser = $futurInvestisseurRepository->findByUser($user_id);
        $role = $userRepository->getTheUser($loggedInUser)->getRoles();
        $result = [
            "id"=>$loggedInUser->getId(),
            "role"=>$role[0],
            "nom" => $loggedInUser->getNom(),
            "prenom"=> $loggedInUser->getPrenom(),
            "ste" =>$loggedInUser->getSte(),
            "pays"=> $loggedInUser->getPays(),
            "ville"=> $loggedInUser->getVille(),
            "tel"=>$loggedInUser->getTel(),
            "adresse"=>$loggedInUser->getAdresse(),
            "userId"=>$loggedInUser->getUserId()
        ];
        if(!empty($loggedInUser)){
            return $this->json(['user' => $result]);
        }else{
            return $this->json(['user' => 'null']);
        }

    }
    /**
     * @Route("/isRegistred", name="futur_investisseur_isRegistred", methods={"GET"})
     **/
    public function isRegistred(UserRepository $userRepository, Request $request): Response
    {
        $email = $request->get('email');
        $isRegistred = $userRepository->isRegistred($email);
        $restult = true;
        if($isRegistred == null){
           $restult = false;
        }
        return $this->json(['result' => $restult]);;
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
     * @Route("/api/{id}/update", name="futur_investisseur_update_api", methods={"POST"})
     */
    public function new_update(Request $request, FuturInvestisseurRepository $futurInvestisseurRepository): Response
    {
            $user = $request->get('id');
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $ville= $request->request->get('ville');
            $adresse = $request->request->get('adresse');
            $pays = $request->request->get('pays');
            //var_dump($prenom);die;
            if($nom != '' && $prenom !='' && $ville != '' && $adresse != '' && $pays != ''){
                $investisseur = $futurInvestisseurRepository->findByUser($user);
                $investisseur->setNom($nom);
                $investisseur->setPrenom($prenom);
                $investisseur->setAdresse($adresse);
                $investisseur->setPays($pays);
                $investisseur->setVille($ville);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($investisseur);
                $entityManager->flush();
                return $this->json([
                    'result' => true,
                    'investisseur'=> $investisseur
                ]);
            }else{
                return $this->json([
                    'result' => false,
                    'investisseur'=> null
                ]);
            }



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
