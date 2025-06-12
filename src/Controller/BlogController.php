<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\MyArticles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


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
            'title' => 'Bienvenue sur notre blog ! !'
        ]);
    }

    #[Route('/blog/create', name: 'blog_create')]
    public function createArticle(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new MyArticles();
        $formArticles = $this->createFormBuilder($article)
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('content', TextareaType::class, ['label' => 'Contenu'])
            ->add('image', TextType::class, ['label' => 'Image'])
            ->getForm();

        $formArticles->handleRequest($request);

        if ($formArticles->isSubmitted() && $formArticles->isValid()) {
            $article->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        return $this->render('blog/createArticle.html.twig', [
            'form' => $formArticles->createView(),
        ]);
    }

    #[Route('/blog/contact', name: 'blogContact')]
    public function contactBlog()
    {
        return $this->render('blog/contactBlog.html.twig', [
            'title' => 'Contact',
            'content' => 'Contactez-nous pour plus d\'informations.',
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_show', requirements: ['id' => '\d+'])]
    public function showArticle(\App\Entity\MyArticles  $MyArticles ): Response
    {
        return $this->render('blog/showArticle.html.twig', [
            'article' => $MyArticles,
        ]);
    }
}
