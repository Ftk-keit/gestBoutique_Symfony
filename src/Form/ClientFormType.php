<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Client;
use App\Form\Subscriber\ClientFormSubscriber;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex; 

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'required' => false,
                'label' => 'Surname',
                'attr' => [
                    'placeholder' => 'surname du client',
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
                ],
                'constraints' => [
                  
                    new NotNull([
                        'message' => 'Ce champ ne peut être vide '
                    ]),
                ]
            ])
            ->add('telephone', TelType::class, [
                'required' => false,

                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Téléphone du client',
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
                ],
                'constraints' => [
                    new NotBlank([
                        'message'=> 'Veuillez saisir un numero valide'
                    ]),
                    new NotNull([
                        'message' => 'Ce champ ne peut être vide '
                    ]),

                    new Regex('/^(7[07-8][0-9]{7})$/', 'Format : 77XXXXXX ou 78XXXXXX ou 76XXXXXX')
                ]
            ])
            ->add('adresse', TextareaType::class, [
                'required' => false,

                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse du client',
                    'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
                    'rows' => 3,
                ],
                'constraints' => [
                    // new NotBlank([]),
                    new NotNull([
                        'message' => 'Ce champ ne peut être vide '
                    ]),
                ]
            ]);

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $client = $event->getData();
            $form = $event->getForm();

            if ($client) {
                $client->setSurname(strtoupper($client->getSurname())); 
            }
        });

        $builder->addEventSubscriber(new ClientFormSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
