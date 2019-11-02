<?php

namespace App\Controller;

use App\Entity\HasField;
use App\Form\HasField1Type;
use App\Repository\HasFieldRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hasfield")
 */
class HasFieldController extends AbstractController
{
    /**
     * @Route("/", name="has_field_index", methods={"GET"})
     */
    public function index(HasFieldRepository $hasFieldRepository): Response
    {
        return $this->render('has_field/index.html.twig', [
            'has_fields' => $hasFieldRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="has_field_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hasField = new HasField();
        $form = $this->createForm(HasField1Type::class, $hasField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hasField);
            $entityManager->flush();

            return $this->redirectToRoute('has_field_index');
        }

        return $this->render('has_field/new.html.twig', [
            'has_field' => $hasField,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="has_field_show", methods={"GET"})
     */
    public function show(HasField $hasField): Response
    {
        return $this->render('has_field/show.html.twig', [
            'has_field' => $hasField,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="has_field_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HasField $hasField): Response
    {
        $form = $this->createForm(HasField1Type::class, $hasField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('has_field_index');
        }

        return $this->render('has_field/edit.html.twig', [
            'has_field' => $hasField,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="has_field_delete", methods={"DELETE"})
     */
    public function delete(Request $request, HasField $hasField): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hasField->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hasField);
            $entityManager->flush();
        }

        return $this->redirectToRoute('has_field_index');
    }
}
