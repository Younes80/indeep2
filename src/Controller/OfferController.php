<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\ContractType;
use App\Entity\Offer;
use App\Repository\OfferRepository;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    /**
     * @Route("/", name="offers.list")
     */
    public function offerList(OfferRepository $repo): Response
    {
        $offer_list = $repo->findAll();
        // dd($offer_list);
        return $this->render('offer/index.html.twig', [
            'offer_list' => $offer_list,
        ]);
    }

    /**
     * @route("/offers/delete/{id}", name="offers.delete")
     */
    public function delete(Offer $offer) 
    {
        // dd($offer);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($offer);
        $manager->flush();

        return $this->redirectToRoute("offers.list");
    }


     /**
     * @route("/offers/add", name="offers.create")
     * @route("/offers/{id}/edit/", name="offers.edit")
     */
    public function update(Request $request, Offer $offer = null) {
        if(!$offer) {
            $offer = new Offer();
        }
        // dd($offer);
    
        $formBuilder = $this->createFormBuilder($offer);
        $formBuilder
                    ->add('title', TextType::class, [
                        "label" => 'Titre',
                        'attr' => ["placeholder" => 'Titre', 'class' => "form-control mb-3"]
                    ])
                    ->add('company', TextType::class, [
                        "label" => 'Société',
                        'attr' => ["placeholder" => 'Société', 'class' => "form-control mb-3"]
                    ])
                    ->add('city', TextType::class, [
                        "label" => 'Ville',
                        'attr' => ["placeholder" => 'Ville', 'class' => "form-control mb-3"]
                    ])
                    ->add('description', TextareaType::class,[
                        "label" => "Description de l'offre",
                        'attr' => ["placeholder" => "Description de l'offre", 'class' => "form-control mb-3"]
                    ] )
                    ->add('contract', EntityType::class, [
                        "class" => Contract::class,
                        'label' => 'Contrat',
                        'choice_label' => 'name',
                        'choice_attr' => [ 'attr' => [ 'class' => "d-flex"] ],
                        'multiple' => false,
                        'expanded' => true,
                        'attr' => ['class' => "d-flex justify-content-evenly align-items-center mb-3"]
                    ] )
                    ->add('contractType', EntityType::class, [
                        "class" => ContractType::class,
                        'label' => 'Type de contrat',
                        'choice_label' => 'name',
                        'multiple' => false,
                        'expanded' => true,
                        'attr' => ['class' => "d-flex justify-content-evenly align-items-center mb-3"]
                    ] )
                    ->add("submit", SubmitType::class, [
                        "label" => 'Valider',
                        'attr' => ['class' => "btn bg-color-primary"]
                    ]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $offer = $form->getData();

            if ($offer->getId()){
                $offer->setUpdateAt(new DateTime());
            }
            if(empty($offer->getId())){
                $offer->setCreatedAt(new DateTime());
                $manager->persist($offer);
            }
            // dd($offer);
            $manager->flush();

            return $this->redirectToRoute("offers.list");
        }
        
        return $this->render('offer/edit.offer.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/offers/{id}", name="offers.show")
     */
    public function offerShow(Offer $offer)
    {
        // dd($offer);
        return $this->render('offer/offer.show.html.twig', [
            'offer' => $offer,
        ]);
    }

}
