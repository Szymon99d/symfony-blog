<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
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
        $post = new Post();
        $category->setName("Example category");
        $post->setTitle("Example title");
        $post->setContent("Add more, delete or edit this post");
        $datetime = new DateTime('now');
        $post->setDate($datetime);
        $post->setCategory($category);

        $manager->persist($admin);
        $manager->persist($post);
        $manager->persist($category);
        $manager->flush();
    }
}
