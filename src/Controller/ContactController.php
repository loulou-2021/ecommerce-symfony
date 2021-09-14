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

        // $now = new \DateTimeImmutable(); // L'objet ne peut pas être modifié
        // $future = $now->modify('+30 days');
        // dump($now->format('d-m-Y')); // 13/09/2021
        // dump($future->format('d-m-Y')); // 14/10/2021

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
            $contact->setAskedAt(new \DateTimeImmutable());

            // Insérer en BDD... Persister un objet avec Doctrine
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contact); // Mets de côté l'objet
            $manager->flush(); // INSERT

            // On va rediriger vers la page de contact
            $this->addFlash('success', 'Votre message a été envoyé.');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
