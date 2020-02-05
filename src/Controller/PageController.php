<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="page_index", methods={"GET"})
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }
    /**
     * @Route("/all", name="page_all", methods={"GET"})
     */
    public function allpages(PageRepository $pageRepository): Response
    {
        return $this->json([
            'result' => true,
            'details'=> $pageRepository->findAll(),
        ]);
    }
    /**
     * @Route("/single/{slug}", name="single_page", methods={"GET"})
     */
    public function getpage(Request $request,PageRepository $pageRepository): Response
    {
        $slug = $request->get('slug');
        $page = $pageRepository->findOneBy(['slug'=>$slug]);
        return $this->json([
            'result' => true,
            'page'=> $page,
        ]);
    }
    /**
     * @Route("/add", name="page_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('page_index');
        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_show", methods={"GET"})
     */
    public function show(Page $page): Response
    {
        return $this->render('page/show.html.twig', [
            'page' => $page,
        ]);
    }
    /**
     * @Route("/{slug}/update", name="page_update_by_slug", methods={"GET","POST"})
     */
    public function update(Request $request,PageRepository $pageRepository): Response
    {
        $slug = $request->get('slug');
        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $page = $pageRepository->findOneBy(['slug'=>$slug]);
        if($page){
            $page->setTitle($title);
            $page->setDescription($description);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($page);
        $entityManager->flush();
        return $this->json([
            'result' => true,
            'page'=> $page,
        ]); 
    }
    /**
     * @Route("/{id}/edit", name="page_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('page_index');
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Page $page): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('page_index');
    }
}
