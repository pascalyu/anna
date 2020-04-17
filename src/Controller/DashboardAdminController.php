<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardAdminController extends AbstractController
{
    /**
     * @Route("/dashboard/admin", name="dashboard_admin")
     */
    public function index()
    {


        $dashboardList = array();
        $dashboardList[] = [
            "title" => "Utilisateur",
            "path" => "user_index",
            "path_name" => "Liste des utilisateurs"
        ];
        $dashboardList[] = [
            "title" => "Product",
            "path" => "product_index",
            "path_name" => "liste des produits"
        ];
        $dashboardList[] = [
            "title" => "Category",
            "path" => "category_index",
            "path_name" => "liste des categories"
        ];
        $dashboardList[] = [
            "title" => "Panier",
            "path" => "basket_index",
            "path_name" => "liste des paniers"
        ];
        $dashboardList[] = [
            "title" => "Cpmmande",
            "path" => "order_index",
            "path_name" => "liste des commandes"
        ];


        return $this->render('dashboard_admin/index.html.twig', [
            'dashboardList' => $dashboardList,
        ]);
    }
}
