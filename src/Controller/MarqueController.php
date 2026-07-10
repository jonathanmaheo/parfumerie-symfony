<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Entity\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MarqueController extends AbstractController
{
    #[Route('/marques', name: 'app_marques')]
    public function index(BrandRepository $brandRepository): Response
{
    $brands = $brandRepository->findAll();

    return $this->render('marque/index.html.twig', [
        'brands' => $brands,
    ]);
}

    #[Route('/marques/{id}', name: 'app_brand_show')]
    public function show(Brand $brand): Response
    {
        return $this->render('marque/show.html.twig', [
            'brand' => $brand,
            'parfums' => $brand->getParfums(),
        ]);
    }
}
