<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class EtudiantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        $tab=['mpi','gl','rt','iia','imi'];
        for ($i = 0; $i < 5; $i++) {
            $section = new Section();
            $section->setDesignation($tab[$i]);
            for ($j = 0; $j < 30; $j++) {
                $etudiant = new Etudiant();
                $etudiant->setPrenom($faker->firstName);
                $etudiant->setNom($faker->name);
                $etudiant->setSection($section);
                $section->addEtudiant($etudiant);
                $manager->persist($etudiant);
            }
            $manager->persist($section);
        }
        for ($i = 0; $i< 60; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setPrenom($faker->firstName);
            $etudiant->setNom($faker->name);
            $manager->persist($etudiant);
        }

        $manager->flush();

    }
}




                 