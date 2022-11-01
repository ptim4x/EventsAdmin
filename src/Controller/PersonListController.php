<?php

namespace App\Controller;

use App\Form\PersonListType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonListController extends AbstractController
{
    #[Route('/personlist/format', name: 'app_personlist_format')]
    public function format(Request $request, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PersonListType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Get form datas
            /** @var UploadedFile $personListFile */
            $personListFile = $form->get('personList')->getData();
            $recipientEmail = $form->get('recipientEmail')->getData();

            // Upload personList file 
            $personListFileName = $fileUploader
                ->setSubDirectory($this->getParameter('presonlist_sub_directory'))
                ->setForcedExtension('csv')
                ->upload($personListFile);

            if($personListFileName) {
                // Todo send message notification for async processing

                $this->addFlash(
                    'notice',
                    "Succès: Fichier envoyé au traitement, le résultat sera envoyé à l'adresse {$recipientEmail}"
                );
            } else {
                $this->addFlash(
                    'error',
                    'Erreur: lors de la récupération du fichier, traitement impossible'
                );
            }

            return $this->redirectToRoute('app_personlist_format');
        }

        return $this->renderForm('personlist/format.html.twig', [
            'form' => $form,
        ]);
    }
}
