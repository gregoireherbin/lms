<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Cours;
use App\Entity\Etape;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
   
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Générer des utilisateurs
        $formateurs = [];
        $plainPasswords = [];

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNom($faker->lastName());
            $user->setPrenom($faker->firstName());
            $user->setEmail($faker->email());
            // $plainPassword = $faker->password();
            $plainPassword = '123456';
            $plainPasswords[] = $plainPassword;
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $profils = [['ROLE_ADMIN'],['ROLE_FORMATEUR'],['ROLE_ETUDIANT']];
            $profil = $faker->randomElement($profils);
            $user->setRoles($profil);

            if ($profil === ['ROLE_FORMATEUR']) {
                $formateurs[] = $user;
            }

            $manager->persist($user);
        }
        // var_dump($plainPasswords);

        $manager->flush();

        // Inclure les données des cours à partir du fichier externe
        $courseData = require __DIR__ . '/../Data/course_data.php';
        $courseNames = $courseData['names'];
        $courseDescriptions = $courseData['descriptions'];

        // Générer des cours
        foreach ($courseNames as $courseName) {
            $cours = new Cours();
            $cours->setTitre($courseName);
            $cours->setDescription($courseDescriptions[$courseName]);

            // Associer un formateur aléatoire
            if (count($formateurs) > 0) {
                $formateur = $faker->randomElement($formateurs);
                $cours->setFormateur($formateur);
            }

            $manager->persist($cours);

            // Inclure les données des étapes à partir du fichier externe
            $stepData = require __DIR__ . '/../Data/course_step_data.php';

            // Générer des étapes
            if (isset($stepData[$courseName])) {
                $stepsForCourse = $stepData[$courseName];
                foreach ($stepsForCourse as $step) {
                    $etape = new Etape();
                    $etape->setTitre($step['titre']);
                    $etape->setDescription($step['description']);
                    $etape->setContenu($step['contenu']);
                    $etape->setCours($cours);

                    $manager->persist($etape);
                }
            }
        }

        $manager->flush();
    }
}
