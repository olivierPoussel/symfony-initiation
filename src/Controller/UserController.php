<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserDoctrine;
use App\Form\UserDoctrineType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController 
{
    /**
     * @Route("userDoctrine")
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function userDoctrine(Request $request)
    {
        $user = new UserDoctrine();
        $form = $this->createForm(UserDoctrineType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //enregistrer en bdd le user
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            if($user->getId() !== null) {
                return new Response('formulaire soumis et valide !' . $user->getName(). ' / '.$user->getEmail());
            }
        }

        return $this->render(
            'userForm.html.twig', 
            [
                'title' => 'userDoctrine',
                'formFromController' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("user")
     *
     * @return Response
     */
    public function user(Request $request)
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //user 
            return new Response('formulaire soumis et valide !' . $user->getName(). ' / '.$user->getEmail());
        }

        return $this->render(
            'userForm.html.twig', 
            [
                'title' => 'user',
                'formFromController' => $form->createView(),
            ]
        );
    }
}