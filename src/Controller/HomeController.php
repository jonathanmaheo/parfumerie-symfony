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

    return $this->render('home/catalog.html.twig', [
        'parfums' => $parfums,
        'brands' => $brandRepository->findAll(),
        'families' => $familyRepository->findAll(),
        'selectedBrand' => $brand,
        'selectedFamily' => $family,
        'selectedMaxPrice' => $maxPrice
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