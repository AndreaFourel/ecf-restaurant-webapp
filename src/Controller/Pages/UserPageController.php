<?php

namespace App\Controller\Pages;

use App\Form\UserUpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPageController extends AbstractController
{
    #[Route('/mon-compte', name: 'app_user_page')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('user_page/user_info.html.twig', [
            'controller_name' => 'UserPageController',
            'user' => $user,
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
