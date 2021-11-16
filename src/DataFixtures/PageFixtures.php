<?php

namespace App\DataFixtures;

use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $pageNames = ['Homepage','About-me','Portfolio'];
        $pageTitles = ['Homepage','About me','Portfolio'];
        for($i=0; $i<3; $i++)
        {
            $page = new Page();
            $page->setPageName($pageNames[$i]);
            $page->setTitle($pageTitles[$i]);
            $page->setContent('This is just a sample content');
            $manager->persist($page);
        }
        $manager->flush();
    }
}
