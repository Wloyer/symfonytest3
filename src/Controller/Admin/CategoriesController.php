<?php

namespace App\Controller\Admin;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->findBy([], ['categoryOrder' =>'asc']);

        return $this->render('admin/categories/index.html.twig', compact ('categorie'));
    }
}