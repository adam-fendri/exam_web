<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setPrenom($faker->firstName);
            $etudiant->setNom($faker->name);


            $manager->persist($etudiant);
        }



        $manager->flush();

    }
}
