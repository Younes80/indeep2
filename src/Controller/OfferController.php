<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use DateTime;
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
     * @route("/offers/add", name="offers.create")
     */
    public function create(Request $request) {
        // dd("create offer");
        $offer = new Offer();
        $formBuilder = $this->createFormBuilder($offer);
        $formBuilder
                    ->add('title', TextType::class, [
                        'attr' => ['class' => "form-control mb-3"]
                    ])
                    ->add('company', TextType::class, [
                        'attr' => ['class' => "form-control mb-3"]
                    ])
                    ->add('city', TextType::class, [
                        'attr' => ['class' => "form-control mb-3"]
                    ])
                    ->add('description', TextareaType::class,[
                        'attr' => ['class' => "form-control mb-3"]
                    ] )
                    // ->add('contract')
                    // ->add('contractType')
                    ->add("submit", SubmitType::class, [
                        'attr' => ['class' => "btn bg-color-primary"]
                    ]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer = $form->getData();
            $offer->setCreatedAt(new DateTime());
            // dd($offer);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($offer);
            $manager->flush();

            return $this->redirectToRoute("offers.list");
        }

        return $this->render('offer/new.offer.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @route("/offers/delete/{id}", name="offers.delete")
     */
    public function delete($id) 
    {
        $manager = $this->getDoctrine()->getManager();
        $offer = $this->getDoctrine()->getRepository(Offer::class);
        $offer = $offer->find($id);
        // dd($offer);
        $manager->remove($offer);
        $manager->flush();

        return $this->redirectToRoute("offers.list");
    }


     /**
     * @route("/offers/edit/{id}", name="offers.edit")
     */
    public function update(Request $request, $id) {
        $offer = $this->getDoctrine()->getRepository(Offer::class);
        $offer = $offer->find($id);
        // dd($offer);
        $formBuilder = $this->createFormBuilder($offer);
        $formBuilder
                    ->add('title', TextType::class, [
                        'attr' => ['class' => "form-control mb-3"]
                    ])
                    ->add('company', TextType::class, [
                        'attr' => ['class' => "form-control mb-3"]
                    ])
                    ->add('city', TextType::class, [
                        'attr' => ['class' => "form-control mb-3"]
                    ])
                    ->add('description', TextareaType::class,[
                        'attr' => ['class' => "form-control mb-3"]
                    ] )
                    // ->add('contract')
                    // ->add('contractType')
                    ->add("submit", SubmitType::class, [
                        'attr' => ['class' => "btn bg-color-primary"]
                    ]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $offer = $form->getData();
            $offer->setUpdateAt(new DateTime());
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
