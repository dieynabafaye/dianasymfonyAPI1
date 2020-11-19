<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public const Admin_Reference = 'Admin';
    public const Cm_Reference = 'Cm';
    public const Formateur_Reference = 'Formateur';
    public const Apprenant_Reference = 'Apprenant';

    public function load(ObjectManager $manager)
    {
        $admin = new Profil();
        $admin->setLibelle('Admin');
        $manager->persist($admin);
        $this->addReference(self::Admin_Reference, $admin);


        $cm = new Profil();
        $cm->setLibelle('Cm');
        $manager->persist($cm);
        $this->addReference(self::Cm_Reference, $cm);


        $formateur = new Profil();
        $formateur->setLibelle('Formateur');
        $manager->persist($formateur);
        $this->addReference(self::Formateur_Reference, $formateur);


        $apprenant = new Profil();
        $apprenant->setLibelle('Apprenant');
        $manager->persist($apprenant);
        $this->addReference(self::Apprenant_Reference, $apprenant);

        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();

    }
}
