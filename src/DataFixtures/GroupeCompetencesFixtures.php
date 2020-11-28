<?php

namespace App\DataFixtures;

use App\Entity\Competences;
use App\Entity\GroupeCompetences;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupeCompetencesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tabDev=['html','php','javascript','mysql','Anglais des affaires','Marketing','Community management'];
        $tabLibelle=['Developpement web','Gestions'];
        $niveauTab = ['Niveau 1', 'Niveau 2', 'Niveau 3'];
        $tabDescriptif=['Descritif en Developpement web', 'Descritif en Gestion'];
            for ($j=0; $j<2; $j++) {
                $grpcompetences1 = new GroupeCompetences();
                $grpcompetences1->setLibelle($tabLibelle[$j])
                    ->setDescriptif($tabDescriptif[$j]);
                $manager->persist($grpcompetences1);
                for ($i = 0; $i < 7; $i++) {
                    $competences = new Competences();
                    $competences->setLibelle($tabDev[$i]);
                        for($j=0; $j<3; $j++){
                            $niveau= new Niveau();
                            $niveau->setLibelle("Niveau ".($j+1))
                                ->setCritereEvaluation("Critere Evaluation ".($j+1))
                                ->setGroupeAction("Groupe Action ".($j+1));
                                $manager->persist($niveau);
                                $competences->addNiveau($niveau);
                        }
                       $competences ->addGroupeCompetence($grpcompetences1);
                    $manager->persist($competences);
                }
            }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}