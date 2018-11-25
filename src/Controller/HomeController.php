<?php
/**
 * Home controller file
 *
 * PHP Version 7.2
 *
 * @category Controller
 * @package  Controller
 * @author   Julie Delmas <julie.delmas33@gmail.com>
 */
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Home page controller.
 *
 * @category Controller
 * @package  Controller
 * @author   Julie Delmas <julie.delmas33@gmail.com>
 */
class HomeController extends AbstractController
{
    /**
     * Showing home page
     *
     * @Route("/", name="homepage")
     * @return     Response A Response instance
     */
    public function index()
    {
        return $this->render('home.html.twig');
    }
}