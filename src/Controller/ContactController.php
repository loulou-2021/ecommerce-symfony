<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $form = $this->createForm(ContactType::class, $contact);

        // On va faire le lien entre notre formulaire et les donnée de la requête
        $form->handleRequest($request);
        // A cette étape, le form de Symfony "hydrate" l'objet
        // C'est à dire qu'il remplit les données de l'objet avec les données du formulaire

        // On vérifie si le formulaire est soumis et aussi valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On peut récupérer les données du formulaire
            // dump($form->getData());
            // dump($contact);
            // Insérer en BDD... Persister un objet avec Doctrine
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contact); // Mets de côté l'objet
            $manager->flush(); // INSERT
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
