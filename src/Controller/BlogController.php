<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\MyArticles;




final class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog')]
    public function index(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(MyArticles::class);
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    #[Route('/', name: 'home')]

    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'welcome to you !',
            'content' => 'notre belle application '
        ]);
    }
    #[Route('/blog/{id}', name: 'blog_show')]
    public function showArticle(MyArticles $article): Response
    {
        return $this->render('blog/showArticle.html.twig', [
            'article' => $article,
        ]);
    }
}
