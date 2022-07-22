<?php

namespace App\DataFixtures;

use App\Entity\Techno;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnoFixtures extends Fixture
{
    const TECHNO = [
        ['name' => 'HTMl', 'image' => 'default1.png', 'progress' => 60],
        ['name' => 'CSS', 'image' => 'default1.png', 'progress' => 50],
        ['name' => 'PHP', 'image' => 'default1.png', 'progress' => 70],
        ['name' => 'Symfony', 'image' => 'default1.png', 'progress' => 60],
        ['name' => 'Python', 'image' => 'default1.png', 'progress' => 50],
        ['name' => 'Sass', 'image' => 'default1.png', 'progress' => 50],
        ['name' => 'Bootstrap', 'image' => 'default1.png', 'progress' => 70],
        ['name' => 'Composer', 'image' => 'default1.png', 'progress' => 30],
        ['name' => 'Yarn', 'image' => 'default1.png', 'progress' => 20],
        ['name' => 'Javascript', 'image' => 'default1.png', 'progress' => 40],
        ['name' => 'Swift', 'image' => 'default1.png', 'progress' => 10],
        ['name' => 'SwiftUI', 'image' => 'default1.png', 'progress' => 40],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::TECHNO as $tech) {
            $techno = new Techno();
            $techno->setName($tech['name']);
            $techno->setProgress($tech['progress']);
            $manager->persist($techno);
        }
        $manager->flush();
    }
}
