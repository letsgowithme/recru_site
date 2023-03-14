<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;


    public function  __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
         //Jobs
         $jobs = [];
         for ($i = 0; $i < 5; $i++) {
             $job = new Job();
             $job->setTitle($this->faker->title())
                 ->setCompany($this->faker->word())
                 ->setLocation($this->faker->text(100))
                 ->setDescription($this->faker->text(100))
                 ->setSalary(mt_rand(1, 1440))
                 ->setSchedule($this->faker->text(100))
                 ->setIsApproved(mt_rand(0, 1) == 1 ? true : false)
                 ->setIsPublished(mt_rand(0, 1) == 1 ? true : false);
 
 
 
             // $job->setUser($users[mt_rand(0, count($users) - 1)]);
             $jobs[] = $job;
             $manager->persist($job);
         }
    

        $manager->flush();
    }
}
