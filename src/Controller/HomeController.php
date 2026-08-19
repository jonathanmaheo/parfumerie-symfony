<?php

namespace App\Controller;

use App\Entity\Parfum;
use App\Repository\FamilyRepository;
use App\Repository\BrandRepository;
use App\Repository\ParfumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/catalogue', name: 'app_catalog')]
    public function catalog(
        Request $request,
        ParfumRepository $parfumRepository,
        BrandRepository $brandRepository,
        FamilyRepository $familyRepository
    ): Response {
        $brand = $request->query->get('brand');
        $family = $request->query->get('family');
        $maxPrice = $request->query->get('maxPrice');

        if ($brand) {
            $parfums = $parfumRepository->findBy([
                'brand' => $brand
            ]);
        } else {
            $parfums = $parfumRepository->findAll();
        }

        if ($family) {
            $parfums = array_filter($parfums, function ($parfum) use ($family) {
                foreach ($parfum->getFamilies() as $parfumFamily) {
                    if ($parfumFamily->getId() == $family) {
                        return true;
                    }
                }

                return false;
            });
        }

        if ($maxPrice) {
            $parfums = array_filter($parfums, function ($parfum) use ($maxPrice) {
                foreach ($parfum->getVariants() as $variant) {
                    if ($variant->getPrice() <= $maxPrice) {
                        return true;
                    }
                }

                return false;
            });
        }

        // Après un filtre, array_filter garde les anciennes clés (2, 5, 8...)
        // On les remet dans l'ordre 0, 1, 2, 3... pour que le tri fonctionne
        $parfums = array_values($parfums);

        // TRI : par ordre alphabétique de marque
        $listeTriee = [];
        while (count($parfums) > 0) {
            $plusPetit = 0;
            for ($i = 1; $i < count($parfums); $i++) {
                $marqueDuParfum = $parfums[$i]->getBrand() ? $parfums[$i]->getBrand()->getTitle() : '';
                $marquePlusPetit = $parfums[$plusPetit]->getBrand() ? $parfums[$plusPetit]->getBrand()->getTitle() : '';
                if ($marqueDuParfum < $marquePlusPetit) {
                    $plusPetit = $i;
                }
            }
            $listeTriee[] = $parfums[$plusPetit];
            unset($parfums[$plusPetit]);
            $parfums = array_values($parfums);
        }
        $parfums = $listeTriee;

        // PAGINATION : 12 parfums par page
        $page = (int) $request->query->get('page', 1);

        // Combien de pages au total ? (sans ceil)
        $nombreParfums = count($parfums);
        $parPage = 12;
        $nombreDePages = (int) ($nombreParfums / $parPage);
        $reste = $nombreParfums % $parPage;

        if ($reste > 0) {
            $nombreDePages = $nombreDePages + 1;
        }

        // Sécurité : toujours au moins 1 page
        if ($nombreDePages < 1) {
            $nombreDePages = 1;
        }

        // Sécurité : on ne dépasse pas la dernière page
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $nombreDePages) {
            $page = $nombreDePages;
        }

        // Page 1 -> position 0, page 2 -> position 12...
        $premierParfum = ($page - 1) * $parPage;

        // On garde seulement les 12 parfums de la page demandée
        $parfums = array_slice($parfums, $premierParfum, $parPage);

        return $this->render('home/catalog.html.twig', [
            'parfums' => $parfums,
            'brands' => $brandRepository->findAll(),
            'families' => $familyRepository->findAll(),
            'selectedBrand' => $brand,
            'selectedFamily' => $family,
            'selectedMaxPrice' => $maxPrice,
            'page'             => $page,
            'nombreDePages'    => $nombreDePages,
            'nombreParfums'    => $nombreParfums,
        ]);
    }

    #[Route('/parfum/{id}', name: 'app_parfum')]
    public function parfum(Parfum $parfum): Response
    {
        return $this->render('home/parfum.html.twig', [
            'parfum' => $parfum
        ]);
    }
}
