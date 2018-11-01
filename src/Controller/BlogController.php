<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("blog/{slug}", requirements={"slug" = "[a-z0-9-]+"}, name="blog_show")
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($slug = null)
    {
        $slug = ucwords($slug);

        if ($slug != null) {
            $slug = str_replace("-", " ", $slug);
        } else {
            $slug = "Article Sans Titre";
        }

        return $this->render('blog/index.html.twig', [
            'slug' => $slug,
        ]);
    }
}
