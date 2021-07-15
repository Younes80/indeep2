<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\ContractType;
use App\Entity\Offer;
use App\Repository\ContractRepository;
use App\Repository\ContractTypeRepository;
use App\Repository\OfferRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(ContractRepository $contractRepo, ContractTypeRepository $contractTypeRepo, OfferRepository $offerRepo): Response
    {
        $contractList = $contractRepo->findAll();
        $contractTypeList = $contractTypeRepo->findAll();
        $offerList = $offerRepo->findAll();

        return $this->render('admin/index.html.twig', [
            'contractList' => $contractList,
            'contractTypeList' => $contractTypeList,
            'offerList' => $offerList,
        ]);
    }

    /**
     * @route("/admin/offers/delete/{id}", name="admin.offers.delete")
     */
    public function deleteOffer(Offer $offer)
    {
        // dd($offer);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($offer);
        $manager->flush();

        return $this->redirectToRoute("admin");
    }

    /**
     * @route("/admin/contracts/delete/{id}", name="admin.contracts.delete")
     */
    public function deleteContract(Contract $contract)
    {
        // dd($offer);
        // dd($contract);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($contract);
        $manager->flush();

        return $this->redirectToRoute("admin");
    }

    /**
     * @route("/admin/contractsType/delete/{id}", name="admin.contractsType.delete")
     */
    public function deleteContractType(ContractType $contractType)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($contractType);
        $manager->flush();

        return $this->redirectToRoute("admin");
    }


    /**
     * @route("/admin/contracts/add", name="admin.contracts.create")
     * @route("/admin/contracts/{id}/edit/", name="admin.contracts.edit")
     */
    public function formContract(Request $request, Contract $contract = null)
    {
        if (!$contract) {
            $contract = new Contract();
            $editMode = false;
        } else {
            $editMode = true;
        }
        $formBuilder = $this->createFormBuilder($contract);
        $formBuilder
            ->add('name', TextType::class, [
                "label" => 'Nom',
                'attr' => ["placeholder" => 'Nom', 'class' => "mb-3"]
            ])
            ->add("submit", SubmitType::class, [
                "label" => 'Valider',
                'attr' => ['class' => "btn bg-color-primary"]
            ]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $contract = $form->getData();
            if (empty($contract->getId())) {
                $manager->persist($contract);
            }
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/edit.contract.html.twig', [
            "form" => $form->createView(),
            "editMode" => $editMode
        ]);
    }



    /**
     * @route("/admin/contractsType/add", name="admin.contractsType.create")
     * @route("/admin/contractsType/{id}/edit/", name="admin.contractsType.edit")
     */
    public function formContractType(Request $request, ContractType $contractType = null)
    {
        if (!$contractType) {
            $contractType = new ContractType();
            $editMode = false;
        } else {
            $editMode = true;
        }

        $formBuilder = $this->createFormBuilder($contractType);
        $formBuilder
            ->add('name', TextType::class, [
                "label" => 'Nom',
                'attr' => ["placeholder" => 'Nom', 'class' => "mb-3"]
            ])
            ->add("submit", SubmitType::class, [
                "label" => 'Valider',
                'attr' => ['class' => "btn bg-color-primary"]
            ]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $contractType = $form->getData();
            if (empty($contractType->getId())) {
                $manager->persist($contractType);
            }
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/edit.contractType.html.twig', [
            "form" => $form->createView(),
            "editMode" => $editMode
        ]);
    }




    /**
     * @route("/admin/offers/add", name="admin.offers.create")
     * @route("/admin/offers/{id}/edit/", name="admin.offers.edit")
     */
    public function formOffer(Request $request, Offer $offer = null)
    {
        if (!$offer) {
            $offer = new Offer();
            $editMode = false;
        } else {
            $editMode = true;
        }

        $formBuilder = $this->createFormBuilder($offer);
        $formBuilder
            ->add('title', TextType::class, [
                "label" => 'Titre',
                'attr' => ["placeholder" => 'Titre', 'class' => "mb-3"]
            ])
            ->add('company', TextType::class, [
                "label" => 'Société',
                'attr' => ["placeholder" => 'Société', 'class' => "mb-3"]
            ])
            ->add('city', TextType::class, [
                "label" => 'Ville',
                'attr' => ["placeholder" => 'Ville', 'class' => "mb-3"]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description de l'offre",
                'attr' => ["placeholder" => "Description de l'offre", 'class' => "mb-3"]
            ])
            ->add('contract', EntityType::class, [
                "class" => Contract::class,
                'label' => 'Contrat',
                'choice_label' => 'name',
                'choice_attr' => ['attr' => ['class' => "d-flex"]],
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => "d-flex flex-wrap align-items-center mb-3"]
            ])
            ->add('contractType', EntityType::class, [
                "class" => ContractType::class,
                'label' => 'Type de contrat',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => "d-flex justify-content-evenly align-items-center mb-3"]
            ])
            ->add("submit", SubmitType::class, [
                "label" => 'Valider',
                'attr' => ['class' => "btn bg-color-primary"]
            ]);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $offer = $form->getData();

            if ($offer->getId()) {
                $offer->setUpdateAt(new \DateTime());
            }
            if (empty($offer->getId())) {
                $offer->setCreatedAt(new \DateTime());
                $manager->persist($offer);
            }
            // dd($offer);
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->render('admin/edit.offer.html.twig', [
            "form" => $form->createView(),
            "editMode" => $editMode
        ]);
    }
}
