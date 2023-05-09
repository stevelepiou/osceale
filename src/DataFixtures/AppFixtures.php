<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this -> faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {

        //Articles
        for ($i=1; $i <= 50; $i++) { 
            $article = new Article();
            $article->setTitre($this->faker->word())
                ->setDescription($this->faker->words(3, true))
                ->setContenu($this->faker->words(10, true));

                $manager->persist($article);
        }

        //Utilisateurs
        $admin = new User();
        $admin->setNom('Bourdji')
            ->setPrenom('Aïcha')
            ->setEmail('admin@osceale.fr')
            ->setRoles(['ROLE_USER','ROLE_ADMIN']);
            
            $hashPassword = $this->hasher->hashPassword(
                $admin,
                'password'
            );
            
                $admin->setPassword($hashPassword);
                

        $users[] =$admin;
        $manager->persist($admin);

        for ($i=0; $i < 10; $i++) { 
            $user = new User();


            $user->setNom($this->faker->name())
                ->setPrenom($this->faker->firstName())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER']);

            $hashPassword = $this->hasher->hashPassword(
                $user,
                'password'
            );
            
                $user->setPassword($hashPassword);
                

                $manager->persist($user);
        }    

        $manager->flush();
    }
}
