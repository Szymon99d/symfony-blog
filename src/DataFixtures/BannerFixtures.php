<?php

namespace App\DataFixtures;

use App\Entity\Banner;
use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BannerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $banner = new Banner();
        $banner->setImage(null);
        $banner->setActive(true);
        $banner->setAltText("Website banner");
        $manager->persist($banner);
        $manager->flush();
    }
}
