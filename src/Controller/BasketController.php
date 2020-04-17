<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\User;
use App\Form\BasketType;
use App\Form\ConfirmOrdersType;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/basket")
 */
class BasketController extends AbstractController
{
    /**
     * @Route("/admin", name="basket_index", methods={"GET"})
     */
    public function index(BasketRepository $basketRepository): Response
    {
        return $this->render('basket/index.html.twig', [
            'baskets' => $basketRepository->findAll(),
        ]);
    }
    /**
     * @Route("/widget", name="basket_widget", methods={"GET"})
     */
    public function basketWidget(BasketRepository $basketRepository): Response
    {
        $total = 0;
        $nbrArticle = 0;
        $basketRows = $basketRepository->findBy(['user' => $this->getUser()]);
        foreach ($basketRows as $row) {
            $nbrArticle += $row->getQuantity();
            $total += ($row->getPrice());
        }
        return $this->render('basket/basket_widget.html.twig', [
            'baskets' => $basketRows,
            'total' => $total,
            'nbrArticle' => $nbrArticle
        ]);
    }

    /**
     * @Route("/", name="basket", methods={"GET|POST"})
     */
    public function basket(Request $request, BasketRepository $basketRepository): Response
    {
        $total = 0;
        $nbrArticle = 0;
        $basketRows = $basketRepository->findBy(['user' => $this->getUser()]);
        $form = $this->createForm(ConfirmOrdersType::class);
        $form->handleRequest($request);
        foreach ($basketRows as $row) {
            $nbrArticle += $row->getQuantity();
            $total += ($row->getPrice());
        }

        if ($form->isSubmitted()) {
            $basketBySeller = [];
            $tmpSellerId = null;
            foreach ($basketRows as $basket) {
                if (!isset($basketBySeller[$basket->getUser()->getId()])) {
                    $basketBySeller[$basket->getUser()->getId()] = array();
                }
                $basketBySeller[$basket->getUser()->getId()][] = $basket;
            }


            $entityManager = $this->getDoctrine()->getManager();

            foreach ($basketBySeller as $sellerId => $sellerBasket) {
                $order = new Order();

                $order->setSeller($this->getDoctrine()->getRepository(User::class)->find($sellerId));
                $order->setBuyer($this->getUser());
                $order->setBillingAddress($this->getUser()->getBillingAddress());
                $order->setShippingAddress($this->getUser()->getShippingAddress());

                $order->setStatus("WAITING_CONFIRM");
                $order->setCodeNumber("todo");
                $totalOrder = 0;
                foreach ($sellerBasket as $basket) {
                    $orderProduct = new OrderProduct();

                    $orderProduct->setProduct($basket->getProduct());
                    $orderProduct->setPrice($basket->getPrice());
                    $orderProduct->setQuantity($basket->getQuantity());
                    $order->addOrderProduct($orderProduct);
                    $totalOrder += $basket->getPrice();
                    $entityManager->persist($orderProduct);
                }
                $order->setPrice($totalOrder);
                $entityManager->persist($order);
            }
            $entityManager->flush();
            $basketRepository->emptyAbasket($this->getUser()->getId());
            return $this->redirectToRoute('order');
        }
        return $this->render('basket/basket.html.twig', [
            'baskets' => $basketRows,
            'total' => $total,
            'nbrArticle' => $nbrArticle,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/new", name="basket_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $basket = new Basket();
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($basket);
            $entityManager->flush();

            return $this->redirectToRoute('basket_index');
        }

        return $this->render('basket/new.html.twig', [
            'basket' => $basket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="basket_show", methods={"GET"})
     */
    public function show(Basket $basket): Response
    {
        return $this->render('basket/show.html.twig', [
            'basket' => $basket,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="basket_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Basket $basket): Response
    {
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('basket_index');
        }

        return $this->render('basket/edit.html.twig', [
            'basket' => $basket,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/basketTodelete", name="basket_all_delete", methods={"POST"})
     */
    public function deleteAll(Request $request, BasketRepository $basketRepository): Response
    {
        $basketRepository->emptyAbasket($this->getUser()->getId());
        return $this->redirectToRoute('basket');
    }
    /**
     * @Route("/{id}", name="basket_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Basket $basket): Response
    {
        if ($this->isCsrfTokenValid('delete' . $basket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($basket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('basket');
    }
}
