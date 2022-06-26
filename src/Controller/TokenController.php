<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\TokenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TokenController extends AbstractController
{
    /**
     * @Route("/token", name="app_token")
     */
    public function index(): Response
    {
        return $this->render('token/index.html.twig', [
            'controller_name' => 'TokenController',
        ]);
    }

    /**
     * @Route("/add-token", name="app_token")
     */
    public function addToken(Request $request): Response
    {

        $token = new Token();

        $form = $this->createForm(TokenType::class, $token);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // add date of creation/update
            // $token->setUpdatedAt(new \DateTimeImmutable());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($token);
            $entityManager->flush();

            return $this->redirectToRoute('app_token');
        }

        return $this->render('token/add.html.twig', [
            'controller_name' => 'TokenController',
            'form' => $form->createView()
        ]);
    }
}
