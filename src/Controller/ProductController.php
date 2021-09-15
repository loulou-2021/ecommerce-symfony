<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request, SluggerInterface $slugger): Response
    {
        // $slugger est un service qu'on récupère avec l'interface SluggerInterface
        // dump($slugger);
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le name est MacBook Pro, le slug est macbook-pro
            $slug = $slugger->slug($product->getName())->lower();
            $product->setSlug($slug);
            $product->setCreatedAt(new \DateTimeImmutable());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
