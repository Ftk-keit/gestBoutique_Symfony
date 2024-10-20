<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \App\Entity\Client;
use \App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
       
        // $product = new Product();
        // $manager->persist($product);
         for ($i = 0; $i < 20; $i++) {
            $client = new Client();
            $client->setSurname("Surnom".$i);
            $client->setTelephone('771234454'.$i);
            $client->setAdresse('Adresse'.$i);
            // Persister l'entité Client
            if ($i %2== 0) { 
                $user = new User();
                $user->setNom('Nom'.$i);
                $user->setPrenom('Prenom'.$i);
                $plaintextPassword = "password";
                $hashedPassword = $this->encoder->hashPassword(
                    $user,
                    $plaintextPassword
                );
                $user->setPassword($plaintextPassword);
                $user->setLogin('Login'.$i);
            }
            $manager->persist($client);
         }
        // $manager->getRepository(Client::class)->createQueryBuilder('c')
        // ->delete()
        // ->getQuery()
        // ->execute();

        $manager->flush();
    }
}
