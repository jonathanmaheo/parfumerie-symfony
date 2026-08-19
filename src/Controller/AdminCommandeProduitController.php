<?php

namespace App\Controller;

use App\Entity\CommandeProduit;
use App\Repository\CommandeProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/commande-produit')]
final class AdminCommandeProduitController extends AbstractController
{
    #[Route(name: 'app_admin_commande_produit_index', methods: ['GET'])]
    public function index(CommandeProduitRepository $commandeProduitRepository): Response
    {
        return $this->render('admin_commande_produit/index.html.twig', [
            'commande_produits' => $commandeProduitRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_commande_produit_show', methods: ['GET'])]
    public function show(CommandeProduit $commandeProduit): Response
    {
        return $this->render('admin_commande_produit/show.html.twig', [
            'commande_produit' => $commandeProduit,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_commande_produit_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeProduit $commandeProduit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeProduit->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($commandeProduit);
            $entityManager->flush();
        }

        $this->addFlash(
            'success',
            'La ligne de commande a bien été supprimée.'
        );

        return $this->redirectToRoute('app_admin_commande_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
