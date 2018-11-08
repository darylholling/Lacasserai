<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        } elseif ($this->security->isGranted('ROLE_USER')) {
//            $users = $this->getDoctrine()->getRepository(User::class)->findBy(['id' => $this->security->getUser()]);
            return $this->render('user/show.html.twig', ['user' => $this->getUser()]);

        } else {
            return $this->render('message/security.html.twig');
        }
        return $this->render('user/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('user_index');
            }

            return $this->render('user/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->render('message/security.html.twig');
        }
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('user/show.html.twig', ['user' => $user]);
        } elseif ($this->security->isGranted('ROLE_USER') && $user == $this->getUser()) {
            return $this->render('user/show.html.twig', ['user' => $this->getUser()]);
        } else {
            return $this->render('message/security.html.twig');
        }
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {

        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_USER') && $user == $this->getUser()) {
            $form = $this->createForm(UserType::class, $user);
        } else {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
