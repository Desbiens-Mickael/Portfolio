<?php

namespace App\DataFixtures;

use App\Entity\Techno;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnoFixtures extends Fixture
{
    const TECHNO = [
        ['name' => 'HTMl', 'image' => 'aaaaaaaa', 'progress' => 60],
        ['name' => 'CSS', 'image' => 'aaaaaaaa', 'progress' => 50],
        ['name' => 'PHP', 'image' => 'aaaaaaaa', 'progress' => 70],
        ['name' => 'Symfony', 'image' => 'aaaaaaaa', 'progress' => 60],
        ['name' => 'Python', 'image' => 'aaaaaaaa', 'progress' => 50],
        ['name' => 'Sass', 'image' => 'aaaaaaaa', 'progress' => 50],
        ['name' => 'Bootstrap', 'image' => 'aaaaaaaa', 'progress' => 70],
        ['name' => 'Composer', 'image' => 'aaaaaaaa', 'progress' => 30],
        ['name' => 'Yarn', 'image' => 'aaaaaaaa', 'progress' => 20],
        ['name' => 'Javascript', 'image' => 'aaaaaaaa', 'progress' => 40],
        ['name' => 'Swift', 'image' => 'aaaaaaaa', 'progress' => 10],
        ['name' => 'SwiftUI', 'image' => 'aaaaaaaa', 'progress' => 40],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::TECHNO as $tech) {
            $techno = new Techno();
            $techno->setName($tech['name']);
            $techno->setImage($tech['image']);
            $techno->setProgress($tech['progress']);
            $manager->persist($techno);
        }
        $manager->flush();
    }
}
