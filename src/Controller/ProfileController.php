<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mon-espace-client')]
final class ProfileController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('', name: 'app_profile')]
    public function index(
        ClientRepository $clientRepository
    ): Response {
        /** @var User|null $user */
        $user = $this->getUser();

        $client = $clientRepository->findOneBy(['email' => $user->getEmail()]);

        $commandes = $client ? $client->getCommandes() : [];

        return $this->render('profile/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}