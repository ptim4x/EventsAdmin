<?php

namespace App\Controller;

use App\Form\PersonListType;
use App\Service\FileUploader;
use App\Message\CsvFormatting;
use App\Service\PersonFormatter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonListController extends AbstractController
{
    #[Route('/personlist/format', name: 'app_personlist_format')]
    public function format(Request $request, FileUploader $fileUploader, MessageBusInterface $bus): Response
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
                // will cause the FileFormattingHandler to be called
                $bus->dispatch(new CsvFormatting($personListFileName, $recipientEmail, PersonFormatter::class));

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
