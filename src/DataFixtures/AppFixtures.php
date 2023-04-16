<?php

namespace App\DataFixtures;

use App\Entity\Candidat;
use App\Entity\Company;
use App\Entity\Job;
use App\Entity\Recruiter;
use App\Entity\User;
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
        // Users
        $users = [];

        $admin = new User();
        $admin->setLastname('Administrateur')
               ->setEmail('admin@recru.fr')
               ->setRoles(['ROLE_ADMIN'])
               ->setPlainPassword('password');
            
               $users[] = $admin;
           $manager->persist($admin);


        for ($j = 0; $j < 10; $j++) {
           $user = new User();
           $user->setLastname($this->faker->lastname())
           ->setFirstname($this->faker->firstname())
               ->setEmail($this->faker->email())
               ->setRoles(mt_rand(0, 1) == 1 ? ['ROLE_CANDIDAT'] : ['ROLE_RECRUITER'])
               ->setPlainPassword('password');
            
               $users[] = $user;
           $manager->persist($user);
       }
    //    $candidats = [];
    //    for ($i = 0; $i < 5; $i++) {
    //        $candidat = new Candidat();
    //        for ($k = 0; $k < mt_rand(5, 5); $k++) {
    //           $candidat->setUser($users[mt_rand(0, count($users) - 1)]);
    //       }
         

    //       $candidats[] = $candidat;
    //       $manager->persist($candidat);
    //   }


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
                 for ($k = 0; $k < mt_rand(5, 5); $k++) {
                    $job->setAuthor($users[mt_rand(0, count($users) - 1)]);
                }
                //  ->setRecruiters($users[mt_rand(0, count($users) - 1)]);
                 for ($k = 0; $k < mt_rand(5, 5); $k++) {
                    $job->addCandidat($users[mt_rand(0, count($users) - 1)]); 
                }
               
             $jobs[] = $job;
             $manager->persist($job);
         }
         $companies = [];
         for ($i = 0; $i < 5; $i++) {
             $company = new Company();
             $company->setTitle($this->faker->title())
                 ->setLocation($this->faker->text(100));
               
             $companies[] = $company;
             $manager->persist($company);
        }
        //  $recruiters = [];
        //  for ($i = 0; $i < 5; $i++) {
        //      $recruiter = new Recruiter();
        //      for ($k = 0; $k < mt_rand(5, 5); $k++) {
        //         $recruiter->setUser($users[mt_rand(0, count($users) - 1)]);
        //     }
        //     for ($k = 0; $k < mt_rand(5, 5); $k++) {
        //         $recruiter->setCompany($companies[mt_rand(0, count($companies) - 1)]);
        //     }
           
        //     $recruiters[] = $recruiter;
        //     $manager->persist($recruiter);
        // }
 

        $manager->flush();
    }
}
