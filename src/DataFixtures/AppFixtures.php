<?php

namespace App\DataFixtures;

use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use App\Factory\PublisherFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AuthorFactory::createMany(10);
        PublisherFactory::createMany(5);
        BookFactory::createMany(20, function () {
            return [
                'author' => AuthorFactory::randomRange(1, 2),
                'publisher' => PublisherFactory::random(),
            ];
        });
        
        // $product = new Product();
        // $manager->persist($product);

        //$manager->flush();
    }
}
