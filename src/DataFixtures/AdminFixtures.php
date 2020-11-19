<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture implements DependentFixtureInterface
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
            $admin = new Admin();
            $hash = $this->encoder->encodePassword($admin, 'password');
            $admin->setEmail($faker->email)
                ->setFirstName($faker->firstname)
                ->setLastName($faker->lastName)
                ->setPassword($hash)
                ->setProfil($this->getReference(ProfilFixtures::Admin_Reference))
                ;
            $manager->persist($admin);
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
