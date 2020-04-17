<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PicturesType;
use App\Form\ProductFilterType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, ProductRepository $productRepository)
    {
        $form = $this->createForm(ProductFilterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();

            $products = $productRepository->findByFilter($data);
        } else {

            $products = $productRepository->findAll();
        }

        return $this->render('home/index.html.twig', [
            'products' => $products,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/labo_test_picture", name="labo_test_picture")
     */
    public function laboTestPicture(Request $request)
    {
        $form = $this->createForm(PicturesType::class, new Picture());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('home/labo_test_picture.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
