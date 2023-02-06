<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/produit', name: 'admin_product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/product/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //On crée un nouveau produit
        $product = new Product();

        //On crée le formulaire
        $productForm = $this->createForm(ProductFormType::class, $product);

        // On traite la requéte du formulaire
        $productForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if($productForm->isSubmitted() && $productForm->isValid()){
            //On génére le slug
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            //On arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);

            // On stock
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avec succès');

            //On redirige
            return $this->redirectToRoute('admin_product_index');
        }
        // return $this->render('admin/product/add.html.twig',[
        //     'productForm' => $productForm->createView()
        // ]);

        return $this->renderForm('admin/product/add.html.twig', compact('productForm'));
        //[productForm => $productForm]
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        //On verifie si l'utilisateur peux éditer avec le voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);
        
        //On divise le prix par 100
            $prix = $product->getPrice() / 100;
            $product->setPrice($prix);
        //On crée le formulaire
        $productForm = $this->createForm(ProductFormType::class, $product);

        // On traite la requéte du formulaire
        $productForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if($productForm->isSubmitted() && $productForm->isValid()){

            //On génére le slug
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            // On stock
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès');

            //On redirige
            return $this->redirectToRoute('admin_product_index');
        }
        // return $this->render('admin/product/edit.html.twig',[
        //     'productForm' => $productForm->createView()
        // ]);

        return $this->renderForm('admin/product/edit.html.twig', compact('productForm'));
        //[productForm => $productForm]
    }
    
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Product $product): Response
    {
        //On verifie si l'utilisateur peux supprimer avec le voter
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);
        return $this->render('admin/product/index.html.twig');
    }
}