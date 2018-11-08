<?php

namespace App\Controller;

use App\Entity\Omgeving;
use App\Form\OmgevingType;
use App\Repository\OmgevingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @Route("/omgeving")
 */
class OmgevingController extends AbstractController
{
    /**
     * @Route("/", name="omgeving_index", methods="GET")
     */
    public function index(OmgevingRepository $omgevingRepository): Response
    {
        return $this->render('omgeving/index.html.twig', ['omgevings' => $omgevingRepository->findAll()]);
    }

    /**
     * @Route("/new", name="omgeving_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $omgeving = new Omgeving();
        $form = $this->createForm(OmgevingType::class, $omgeving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
//            $file = $omgeving->getImagepath();
            $file = $form->get('imagepath')->getData();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $omgeving->setImagepath($fileName);

            // ... persist the $product variable or any other work
            $em = $this->getDoctrine()->getManager();
            $em->persist($omgeving);
            $em->flush();

            return $this->redirectToRoute('omgeving_index');
        }

        return $this->render('omgeving/new.html.twig', [
            'omgeving' => $omgeving,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="omgeving_show", methods="GET")
     */
    public function show(Omgeving $omgeving): Response
    {
        return $this->render('omgeving/show.html.twig', ['omgeving' => $omgeving]);
    }

    /**
     * @Route("/{id}/edit", name="omgeving_edit", methods="GET|POST")
     */
    public function edit(Request $request, Omgeving $omgeving): Response
    {
        $form = $this->createForm(OmgevingType::class, $omgeving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $omgeving->setImagepath(
                new File($this->getParameter('images_directory').'/'.$omgeving->getImagepath())
            );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('omgeving_edit', ['id' => $omgeving->getId()]);
        }

        return $this->render('omgeving/edit.html.twig', [
            'omgeving' => $omgeving,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="omgeving_delete", methods="DELETE")
     */
    public function delete(Request $request, Omgeving $omgeving): Response
    {
        if ($this->isCsrfTokenValid('delete' . $omgeving->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($omgeving);
            $em->flush();
        }

        return $this->redirectToRoute('omgeving_index');
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}