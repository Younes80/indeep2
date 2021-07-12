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
