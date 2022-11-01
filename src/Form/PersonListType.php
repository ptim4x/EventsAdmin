<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PersonListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // person list input file widget
            ->add('personList', FileType::class, [
                'label' => 'Fichier de personnes',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the personList details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2m',
                        'mimeTypes' => [
                            'application/csv',
                            'text/plain',
                        ],
                        'maxSizeMessage' => 'Le fichier est trop lourd, il dépasse 2Mo',
                        'mimeTypesMessage' => 'Un fichier CSV ou TXT est requis',
                    ])
                ],
            ])
            // recipient input mail widget
            ->add('recipientEmail', EmailType::class, [
                'label' => 'Email destinaire du fichier formaté',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the personList details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new Email([
                        'message' => 'L\'email {{ value }} n\'est pas valide',
                    ])
                ],
            ])
            // submit button widget
            ->add('submit', SubmitType::class)
        ;
    }
}