<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        // On prépare une entité
        $contact = new Contact();
        dump($contact);

        // On crée un formulaire avec un Symfony
        $form = $this->createFormBuilder($contact)
            ->add('name')
            ->add('email')
            ->add('message', TextareaType::class)
            ->add('country', CountryType::class)
            ->getForm();

        // On va faire le lien entre notre formulaire et les donnée de la requête
        $form->handleRequest($request);
        // A cette étape, le form de Symfony "hydrate" l'objet
        // C'est à dire qu'il remplit les données de l'objet avec les données du formulaire

        // On vérifie si le formulaire est soumis et aussi valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On peut récupérer les données du formulaire
            // dump($form->getData());
            // dump($contact);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
