<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername("admin");
        $admin->setPassword($this->passwordHasher->hashPassword($admin,"qwerty()*"));
        $admin->setRoles(["ROLE_ADMIN"]);

        $category = new Category();
        $category->setName("Example category");
        for($i=0; $i<10; $i++)
        {
            $post = new Post();
            $post->setTitle("Example title ".$i);
            $post->setContent("Add more, delete or edit this post");
            $datetime = new DateTime('now');
            $datetime->add(new DateInterval("P".$i."D"));
            $post->setDate($datetime);
            $post->setCategory($category);
            $manager->persist($post);
        }
        $manager->persist($admin);
        $manager->persist($category);
        $manager->flush();
    }
}
