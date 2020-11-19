<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormateurFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    public function  __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('fr_FR');
        for($i=0; $i<4; $i++){
            $formateur = new Formateur();
            $hash = $this->encoder->encodePassword($formateur, 'password');
            $formateur->setEmail($faker->email)
                ->setFirstName($faker->firstname)
                ->setLastName($faker->lastName)
                ->setPassword($hash)
                ->setProfil($this->getReference(ProfilFixtures::Formateur_Reference))
            ;
            $manager->persist($formateur);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return array(
            ProfilFixtures::class
        );
    }
}
