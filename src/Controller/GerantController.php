<?php

namespace App\Controller;

use App\Entity\Gerant;
use App\Entity\User;
use App\Form\GerantType;
use App\Repository\GerantRepository;
use App\Repository\ProprietaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gerant')]
class GerantController extends AbstractController
{
    #[Route('/', name: 'app_gerant_index', methods: ['GET'])]
    public function index(GerantRepository $gerantRepository): Response
    {
        return $this->render('gerant/index.html.twig', [
            'gerants' => $gerantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gerant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, ProprietaireRepository $proprietaireRepository): Response
    {
        $gerant = new Gerant();
        $user = new User();
        $form = $this->createForm(GerantType::class, $gerant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $gerant->setPassword($user->getPassword());
            $user->setEmail($gerant->getEmail());
            $user->setTelephone($gerant->getTelephone());
            $user->setNom($gerant->getNom());
            $user->setPrenom($gerant->getPrenom());
            $user->setAdresse($gerant->getAdresse());
            $u = $this->getUser();
            $roles = [];
            $roles[] = "ROLE_GERANT";
            $proprietaire = $proprietaireRepository->findOneBy(["email" => $u->getUserIdentifier()]);
            $user->setRoles($roles);
            $gerant->setProprietaire($proprietaire);
            $entityManager->persist($gerant);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_gerant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gerant/new.html.twig', [
            'gerant' => $gerant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gerant_show', methods: ['GET'])]
    public function show(Gerant $gerant): Response
    {
        return $this->render('gerant/show.html.twig', [
            'gerant' => $gerant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gerant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gerant $gerant, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
        $form = $this->createForm(GerantType::class, $gerant);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(["email" => $gerant->getEmail()]);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setEmail($gerant->getEmail());
            $user->setTelephone($gerant->getTelephone());
            $user->setNom($gerant->getNom());
            $user->setPrenom($gerant->getPrenom());
            $user->setAdresse($gerant->getAdresse());
            $gerant->setPassword($user->getPassword());
            $entityManager->persist($user);
            $entityManager->persist($gerant);
            $entityManager->flush();

            return $this->redirectToRoute('app_gerant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gerant/edit.html.twig', [
            'gerant' => $gerant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gerant_delete', methods: ['POST'])]
    public function delete(Request $request, Gerant $gerant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gerant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($gerant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gerant_index', [], Response::HTTP_SEE_OTHER);
    }
}