<?php

namespace App\Controller\Pages;

use App\Entity\Reservation;
use App\Form\UserUpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPageController extends AbstractController
{
    #[Route('/mon-compte', name: 'app_user_page')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $user_mail = $this->getUser()->getUserIdentifier();

        $reservations = $doctrine->getRepository(Reservation::class)->findBy(['email' => $user_mail], ['id' => 'DESC'], 5);
        //dd($reservations);

        return $this->render('user_page/user_info.html.twig', [
            'title' => 'Mon compte',
            'user' => $user,
            'reservations' => $reservations,
        ]);
    }



    #[Route('/mon-compte/mise-a-jour', name: 'app_update_user')]
    public function update(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserUpdateFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_page');
        }

        return $this->render('user_page/user_update_info.html.twig', [
            'title' => 'Modifier mon compte',
            'userUpdateForm' => $form->createView(),
    ]);
    }
}
