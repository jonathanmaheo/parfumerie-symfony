<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Repository\CommandeRepository;
use App\Repository\ParfumVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommandeController extends AbstractController
{
    #[Route('/commande/valider', name: 'app_commande_valider')]
    public function valider(
        Request $request,
        ParfumVariantRepository $parfumVariantRepository,
        EntityManagerInterface $entityManager,
        ClientRepository $clientRepository
    ): Response {
        $panier = $request->getSession()->get('panier', []);

        if (empty($panier)) {
            $this->addFlash(
                'danger',
                'Votre panier est vide.'
            );

            return $this->redirectToRoute('app_panier');
        }

        $commande = new Commande();
        $commande->setDate(new \DateTimeImmutable());

        $user = $this->getUser();

        if ($user) {
            $client = $clientRepository->findOneBy(['email' => $user->getEmail()]);

            if (!$client) {
                $client = new Client();
                $client->setName($user->getFirstName() . ' ' . $user->getLastName());
                $client->setEmail($user->getEmail());
                $entityManager->persist($client);
            }

            $commande->setClient($client);
        }

        foreach ($panier as $variantId => $quantite) {
            $variant = $parfumVariantRepository->find($variantId);

            if (!$variant) {
                continue;
            }

            if ($quantite > $variant->getStock()) {
                $this->addFlash(
                    'danger',
                    'Le stock de ' . $variant->getParfum()->getName() . ' est insuffisant.'
                );

                return $this->redirectToRoute('app_panier');
            }

            $commandeProduit = new CommandeProduit();
            $commandeProduit->setParfumVariant($variant);
            $commandeProduit->setQuantity($quantite);

            $commande->addCommandeProduit($commandeProduit);

            $variant->setStock($variant->getStock() - $quantite);
        }

        $entityManager->persist($commande);
        $entityManager->flush();

        $request->getSession()->remove('panier');

        $this->addFlash(
            'success',
            'Votre commande n°' . $commande->getId() . ' a bien été enregistrée.'
        );

        return $this->redirectToRoute('app_commande_confirmation', [
            'id' => $commande->getId(),
        ]);
    }


    #[Route('/commande/paiement', name: 'app_commande_paiement')]
    public function paiement(
        Request $request,
        ParfumVariantRepository $parfumVariantRepository
    ): Response {
        $panier = $request->getSession()->get('panier', []);

        $panierComplet = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $variant = $parfumVariantRepository->find($id);

            if (!$variant) {
                continue;
            }

            $sousTotal = $variant->getPrice() * $quantite;

            $panierComplet[] = [
                'variant' => $variant,
                'quantite' => $quantite,
                'sousTotal' => $sousTotal,
            ];

            $total += $sousTotal;
        }

        return $this->render('commande/paiement.html.twig', [
            'panier' => $panierComplet,
            'total' => $total,
        ]);
    }



    #[Route('/commande/confirmation/{id}', name: 'app_commande_confirmation')]
    public function confirmation(
        int $id,
        CommandeRepository $commandeRepository
    ): Response {
        $commande = $commandeRepository->find($id);

        if (!$commande) {
            return $this->redirectToRoute('app_panier');
        }

        return $this->render('commande/confirmation.html.twig', [
            'commande' => $commande,
        ]);
    }
}
