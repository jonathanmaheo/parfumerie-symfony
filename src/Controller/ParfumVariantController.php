<?php

namespace App\Controller;

use App\Entity\ParfumVariant;
use App\Form\ParfumVariantType;
use App\Repository\ParfumRepository;
use App\Repository\ParfumVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/parfum-variant')]
final class ParfumVariantController extends AbstractController
{
    #[Route(name: 'app_parfum_variant_index', methods: ['GET'])]
    public function index(ParfumVariantRepository $parfumVariantRepository): Response
    {
        return $this->render('parfum_variant/index.html.twig', [
            'parfum_variants' => $parfumVariantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_parfum_variant_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        ParfumRepository $parfumRepository
    ): Response {
        $parfumVariant = new ParfumVariant();

        $parfumId = $request->query->get('parfum');

        if ($parfumId) {
            $parfum = $parfumRepository->find($parfumId);

            if ($parfum) {
                $parfumVariant->setParfum($parfum);
            }
        }

        $form = $this->createForm(ParfumVariantType::class, $parfumVariant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parfumVariant);
            $entityManager->flush();

            return $this->redirectToRoute('app_parfum_variant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parfum_variant/new.html.twig', [
            'parfum_variant' => $parfumVariant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parfum_variant_show', methods: ['GET'])]
    public function show(ParfumVariant $parfumVariant): Response
    {
        return $this->render('parfum_variant/show.html.twig', [
            'parfum_variant' => $parfumVariant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parfum_variant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ParfumVariant $parfumVariant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParfumVariantType::class, $parfumVariant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parfum_variant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parfum_variant/edit.html.twig', [
            'parfum_variant' => $parfumVariant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parfum_variant_delete', methods: ['POST'])]
    public function delete(Request $request, ParfumVariant $parfumVariant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parfumVariant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parfumVariant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parfum_variant_index', [], Response::HTTP_SEE_OTHER);
    }
}
