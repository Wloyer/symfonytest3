<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie', name: 'categorie_')]
class CategorieController extends AbstractController
{

     #[Route('/{slug}', name: 'list')]
     public function list(Categorie $category ): Response
     {
        //on va chercher la liste des produits de la categorie
        $product = $category->getProducts();
        return $this->render('categorie/list.html.twig', compact('category', 'product'));
     }
}