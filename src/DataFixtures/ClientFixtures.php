<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \App\Entity\Client;
use \App\Entity\User;
use \App\Entity\Dette;

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
            $client->setTelephone('77123445'.$i);
            if ($i >= 10) {
                $client->setTelephone('7712344'.$i);
            }
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
                $user->setPassword($hashedPassword);
                $user->setLogin('Login'.$i);
                $user->setActive(true);
                $client->setAccount($user);
            }
            if ($i %3== 0) { 
                $dette = new Dette();
                $dette->setData(new \DateTime()); 
                $dette->setMontant(rand(100, 1000)); 
                $dette->setMontantVerser(0); 
                
                $dette->setClient($client);
                
                $manager->persist($dette);

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
