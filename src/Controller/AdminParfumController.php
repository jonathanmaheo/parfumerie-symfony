<?php

namespace App\Controller;

use App\Entity\Parfum;
use App\Form\ParfumType;
use App\Repository\ParfumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/parfum')]
final class AdminParfumController extends AbstractController
{
    #[Route(name: 'app_admin_parfum_index', methods: ['GET'])]
    public function index(ParfumRepository $parfumRepository): Response
    {
        return $this->render('admin_parfum/index.html.twig', [
            'parfums' => $parfumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_parfum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parfum = new Parfum();
        $form = $this->createForm(ParfumType::class, $parfum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parfum);
            $entityManager->flush();

            return $this->redirectToRoute('app_parfum_variant_new', ['parfum' => $parfum->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_parfum/new.html.twig', [
            'parfum' => $parfum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_parfum_show', methods: ['GET'])]
    public function show(Parfum $parfum): Response
    {
        return $this->render('admin_parfum/show.html.twig', [
            'parfum' => $parfum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_parfum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parfum $parfum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParfumType::class, $parfum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_parfum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_parfum/edit.html.twig', [
            'parfum' => $parfum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_parfum_delete', methods: ['POST'])]
    public function delete(Request $request, Parfum $parfum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $parfum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parfum);
            $entityManager->flush();
        }

        $this->addFlash(
            'success',
            'Le parfum a bien été supprimé.'
        );

        return $this->redirectToRoute('app_admin_parfum_index', [], Response::HTTP_SEE_OTHER);
    }
}
