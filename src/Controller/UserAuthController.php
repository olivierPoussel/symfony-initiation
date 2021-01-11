<?php

namespace App\Controller;

use App\Entity\UserAuth;
use App\Form\UserAuthType;
use App\Repository\UserAuthRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user/auth")
 */
class UserAuthController extends AbstractController
{
    /**
     * @Route("/", name="user_auth_index", methods={"GET"})
     */
    public function index(UserAuthRepository $userAuthRepository): Response
    {
        return $this->render('user_auth/index.html.twig', [
            'user_auths' => $userAuthRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_auth_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $userAuth = new UserAuth();
        $form = $this->createForm(UserAuthType::class, $userAuth);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $userAuth->setPassword(
                $encoder->encodePassword($userAuth, $userAuth->getPassword())
            );
            $entityManager->persist($userAuth);
            $entityManager->flush();

            return $this->redirectToRoute('user_auth_index');
        }

        return $this->render('user_auth/new.html.twig', [
            'user_auth' => $userAuth,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_auth_show", methods={"GET"})
     */
    public function show(UserAuth $userAuth): Response
    {
        return $this->render('user_auth/show.html.twig', [
            'user_auth' => $userAuth,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_auth_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserAuth $userAuth, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserAuthType::class, $userAuth);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userAuth->setPassword(
                $encoder->encodePassword($userAuth, $userAuth->getPassword())
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_auth_index');
        }

        return $this->render('user_auth/edit.html.twig', [
            'user_auth' => $userAuth,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_auth_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserAuth $userAuth): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userAuth->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userAuth);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_auth_index');
    }
}
