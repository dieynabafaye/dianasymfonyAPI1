<?php

namespace App\DataFixtures;

use App\Entity\Cm;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CmFixtures extends Fixture implements DependentFixtureInterface
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
            $cm = new Cm();
            $hash = $this->encoder->encodePassword($cm, 'password');
            $cm->setEmail($faker->email)
                ->setFirstName($faker->firstname)
                ->setLastName($faker->lastName)
                ->setPassword($hash)
                ->setProfil($this->getReference(ProfilFixtures::Cm_Reference))
            ;
            $manager->persist($cm);
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
