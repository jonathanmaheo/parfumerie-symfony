<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ParfumVariantRepository;
use App\Entity\ParfumVariant;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(
        Request $request,
        ParfumVariantRepository $parfumVariantRepository
    ): Response {
        $panier = $request->getSession()->get('panier', []);

        $panierComplet = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $variant = $parfumVariantRepository->find($id);

            if (!$variant) {
                unset($panier[$id]);
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

        $request->getSession()->set('panier', $panier);

        return $this->render('panier/index.html.twig', [
            'panier' => $panierComplet,
            'total' => $total,
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'app_panier_ajouter')]
    public function ajouter(
        ParfumVariant $parfumVariant,
        Request $request
    ): Response {
        $panier = $request->getSession()->get('panier', []);

        $id = $parfumVariant->getId();
        $stock = $parfumVariant->getStock();

        if ($stock <= 0) {
            $this->addFlash(
                'danger',
                'Ce parfum est en rupture de stock.'
            );

            return $this->redirectToRoute('app_catalog');
        }

        $quantiteActuelle = $panier[$id] ?? 0;

        if ($quantiteActuelle >= $stock) {
            $this->addFlash(
                'danger',
                'Stock maximum atteint pour ce parfum.'
            );

            return $this->redirectToRoute('app_catalog');
        }

        $panier[$id] = $quantiteActuelle + 1;

        $request->getSession()->set('panier', $panier);

        $this->addFlash(
            'success',
            'Le parfum a bien été ajouté au panier.'
        );

        return $this->redirectToRoute('app_catalog');
    }

    #[Route('/panier/plus/{id}', name: 'app_panier_plus')]
    public function plus(
        ParfumVariant $parfumVariant,
        Request $request
    ): Response {
        $panier = $request->getSession()->get('panier', []);

        $id = $parfumVariant->getId();
        $stock = $parfumVariant->getStock();

        if (isset($panier[$id])) {

            if ($panier[$id] >= $stock) {
                $this->addFlash(
                    'danger',
                    'Stock maximum atteint pour ce parfum.'
                );

                return $this->redirectToRoute('app_panier');
            }

            $panier[$id]++;
        }

        $request->getSession()->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/minus/{id}', name: 'app_panier_minus')]
    public function minus(
        ParfumVariant $parfumVariant,
        Request $request
    ): Response {
        $panier = $request->getSession()->get('panier', []);

        $id = $parfumVariant->getId();

        if (isset($panier[$id])) {

            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        $request->getSession()->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/supprimer/{id}', name: 'app_panier_supprimer')]
    public function supprimer(
        ParfumVariant $parfumVariant,
        Request $request
    ): Response {
        $panier = $request->getSession()->get('panier', []);

        $id = $parfumVariant->getId();

        if (isset($panier[$id])) {
            unset($panier[$id]);
        }

        $request->getSession()->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }
}
