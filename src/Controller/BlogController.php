<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class BlogController
 * @package App\Controller
 * @route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
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
     * @param CategoryRepository $categoryRepository
     * @param ArticleRepository $articleRepository
     * @param ObjectManager $manager
     */
    public function __construct(CategoryRepository $categoryRepository, ArticleRepository $articleRepository, ObjectManager $manager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->manager = $manager;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Show all row from article's entity
     * @Route("/home", name="blog_index")
     */
    public function index()
    {
        $articles = $this->articleRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);

    }

    /**
     * Getting an article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     */
/*    public function show($slug)
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug
            ]
        );
    }*/

    /**
     * Selecting all articles by category
     * @param string $category the category
     * @Route("/category/{category}", name="blog_show_category")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByCategory(string $category)
    {
        $categories = $this->categoryRepository->findOneByName($category);
        $articles = $this->articleRepository->findBy(['category' => $categories->getId()], ['id' => 'DESC'], 3);

        return $this->render('blog/category.html.twig', [
            'category' => $categories,
            'articles' => $articles
        ]);
    }

    /**
     * @Route ("/category", name="category_new")
     * @param Request $request
     * @return Response
     */
    public function newCategory(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($category);
            $this->manager->flush();
            $this->addFlash('success', 'Catégorie créée avec succès');
            return $this->redirectToRoute('blog_index');
        }

        return $this->render('blog/newCategory.html.twig', [
            'category' => $category,
            'form'     => $form->createView()
        ]);
    }
}
