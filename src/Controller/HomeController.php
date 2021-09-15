<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $repository): Response
    {
        dump($repository);
        // $repository2 = $this->getDoctrine()->getRepository(Product::class);
        // dump($repository2);

        return $this->render('home/index.html.twig', [
            'randomProducts' => $repository->findAll(),
            'randomLikedProduct' => $repository->findOneByLiked(true), // where liked = 1
            'lastProducts' => $repository->findAll(),
            'bestProducts' => $repository->findAll(),
        ]);
    }
}
