<?php


namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/", name ="homepage")
     */
    public function index()
    {
        return $this ->render(
            'base.html.twig',
            [
                'name' => 'LP'
            ]
        );
    }

}