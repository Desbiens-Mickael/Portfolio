<?php

namespace App\DataFixtures;

use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjetFixtures extends Fixture
{
    private $slugger;
    public function __construct(SluggerInterface $slugger){
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $projet = new Projet();
            $projet->setName($faker->words(3, true));
            $projet->setDescriptif($faker->paragraphs(4, true));
            $projet->setLink('#');
            $projet->setSlug($this->slugger->slug(strtolower($projet->getName())));
            $projet->setDate(new \DateTime());
            $manager->persist($projet);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
