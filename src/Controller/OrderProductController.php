<?php

namespace App\Controller;

use App\Entity\OrderProduct;
use App\Form\OrderProductType;
use App\Repository\OrderProductRepository;
use App\Repository\OrderProductRepostiory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/product")
 */
class OrderProductController extends AbstractController
{
    /**
     * @Route("/", name="order_product_index", methods={"GET"})
     */
    public function index(OrderProductRepository $orderProductRepository): Response
    {
        return $this->render('order_product/index.html.twig', [
            'order_products' => $orderProductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="order_product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderProduct = new OrderProduct();
        $form = $this->createForm(OrderProductType::class, $orderProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderProduct);
            $entityManager->flush();

            return $this->redirectToRoute('order_product_index');
        }

        return $this->render('order_product/new.html.twig', [
            'order_product' => $orderProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_product_show", methods={"GET"})
     */
    public function show(OrderProduct $orderProduct): Response
    {
        return $this->render('order_product/show.html.twig', [
            'order_product' => $orderProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderProduct $orderProduct): Response
    {
        $form = $this->createForm(OrderProductType::class, $orderProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_product_index');
        }

        return $this->render('order_product/edit.html.twig', [
            'order_product' => $orderProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrderProduct $orderProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_product_index');
    }
}
