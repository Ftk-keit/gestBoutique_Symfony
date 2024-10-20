<?php

namespace App\Form\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClientFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event)
    {
        // $client = $event->getData();
        // $form = $event->getForm();

        // if ($client && $client->getId()) {
        //     $form->add('email', EmailType::class, [
        //         'label' => 'Email',
        //         'attr' => [
        //             'placeholder' => 'Email du client',
        //             'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline',
        //         ],
        //     ]);
        // }
    }

    public function onPostSubmit(FormEvent $event)
    {
        $client = $event->getData();
        // Exemple de logique après la soumission
        // Validation ou traitement supplémentaire
    }
}
