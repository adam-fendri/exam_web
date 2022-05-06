<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SectionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $tab=['mpi','gl','rt','iia','imi'];
        for ($i = 0; $i < 5; $i++) {
            $section = new Section();
            $section->setDesignation($tab[$i]);

            $manager->persist($section);
        }

        $manager->flush();
    }
}
