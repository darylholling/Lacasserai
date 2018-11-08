<?php

namespace App\Controller;

use App\Entity\Bankcard;
use App\Form\BankcardType;
use App\Repository\BankcardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/bankcard")
 */
class BankcardController extends AbstractController
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="bankcard_index", methods="GET")
     */
    public function index(BankcardRepository $bankcardRepository): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('bankcard/index.html.twig', ['bankcards' => $bankcardRepository->findAll()]);
        } elseif ($this->security->isGranted('ROLE_USER')) {
            return $this->render('bankcard/index.html.twig', ['bankcards' => $bankcardRepository->findBy(['userId' => $this->security->getUser()])]);
        } else {
            return $this->render('message/security.html.twig');
        }
    }

    /**
     * @Route("/new", name="bankcard_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $bankcard = new Bankcard();
            $form = $this->createForm(BankcardType::class, $bankcard);
            $form->handleRequest($request);
        } elseif ($this->security->isGranted('ROLE_USER')) {
            $bankcard = new Bankcard();
            $form = $this->createForm(BankcardType::class, $bankcard);
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $form->handleRequest($request);
            $bankcard->setUserId($user);
        } else {
            return $this->render('message/security.html.twig');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bankcard);
            $em->flush();

            return $this->redirectToRoute('bankcard_index');
        }

        return $this->render('bankcard/new.html.twig', [
            'bankcard' => $bankcard,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="bankcard_show", methods="GET")
     */
    public function show(Bankcard $bankcard): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('bankcard/show.html.twig', ['bankcard' => $bankcard]);
        } elseif ($this->security->isGranted('ROLE_USER') && $bankcard->getUserId() == $this->getUser()) {
            return $this->render('bankcard/show.html.twig', ['bankcard' => $bankcard]);
        } else {
            return $this->render('message/security.html.twig');
        }
    }

    /**
     * @Route("/{id}/edit", name="bankcard_edit", methods="GET|POST")
     */
    public function edit(Request $request, Bankcard $bankcard): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(BankcardType::class, $bankcard);
        } elseif ($this->security->isGranted('ROLE_USER') && $bankcard->getUserId() == $this->getUser()) {
            $form = $this->createForm(BankcardType::class, $bankcard);
        } else {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');

        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('bankcard_edit', ['id' => $bankcard->getId()]);
        }
        return $this->render('bankcard/edit.html.twig', [
            'bankcard' => $bankcard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bankcard_delete", methods="DELETE")
     */
    public function delete(Request $request, Bankcard $bankcard): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bankcard->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bankcard);
            $em->flush();
        }

        return $this->redirectToRoute('bankcard_index');
    }
}
