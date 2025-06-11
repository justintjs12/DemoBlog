<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MyArticles;
class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       for ($i = 1; $i <= 50; $i++) {
            $article = new MyArticles();
            $article->setTitle("titre de l'article" . $i);
            $article->setContent('Content of article ' . $i);
            $article->setImage('https://picsum.photos/600/400?random=' . $i);
            $article->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
