<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * BlogController constructor.
     * @param CategoryRepository $repository
     * @param ArticleRepository $articleRepository
     * @param ObjectManager $manager
     */
    public function __construct(CategoryRepository $repository, ArticleRepository $articleRepository, ObjectManager $manager)
    {

        $this->repository = $repository;
        $this->manager = $manager;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/blog", name="blog_category")
     */
    public function showCategories()
    {
        $categories = $this->repository->findAll();

        return $this->render('blog/show.html.twig', [
            'categories' => $categories,
        ]);
    }
}
