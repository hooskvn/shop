<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/add', name: 'create_product', methods: 'POST')]
    public function createProduct(
        ProductRepository $productRepository,
        Request $request
        ): Response
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setTitle($data['title']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        $product->setActive($data['isActive']);

        $productRepository->add($product, true);

        return new Response(
            sprintf(
                'Saved new product with id #%d',
                $product->getId()
            ),
            Response::HTTP_OK
        );
    }

    #[Route('/product/{id}', name: 'get_product', methods: 'GET')]
    public function getProduct(ProductRepository $productRepository, $id): Response
    {
        $product = $productRepository->find($id);
        $productAsArray = [
            'id' => $product->getId(),
            'title' => $product->getTitle(),
            'price' => $product->getPrice(),
            'dedscription' => $product->getDescription(),
            'stock' => $product->isActive() ? 'available' : 'unavailable'
        ];

        return new Response(json_encode($productAsArray), Response::HTTP_OK);
    }

    #[Route('/products', name: 'get_products', methods: 'GET')]
    public function getProducts(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        $productsList = [];

        foreach ($products as $product) {
            $productsList[] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'price' => $product->getPrice(),
                'dedscription' => $product->getDescription(),
                'stock' => $product->isActive() ? 'available' : 'unavailable'
            ];
        }

        return new Response(json_encode($productsList), Response::HTTP_OK);
    }

    #[Route('/products/available', name: 'get_products_available', methods: 'GET')]
    public function getProductsAvailable(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findProductsAvailable();
        $productsList = [];

        foreach ($products as $product) {
            $productsList[] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
                'isActive' => $product->isActive() ? 'active' : 'inactive',
                'stock' => $product->getStock(),
            ];
        }

        return new Response(json_encode($productsList), Response::HTTP_OK);
    }

    #[Route('/products/edit/{id}', name: 'edit_product', methods: 'PUT')]
    public function editProduct(
        ProductRepository $productRepository,
        Request $request,
        $id
        ): Response
    {
        $data = json_decode($request->getContent(), true);

        $product = $productRepository->find($id);
        $product->setTitle($data['title']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        $product->setActive($data['isActive']);
        $product->setStock($data['stock']);

        $productRepository->add($product, true);

        return new Response(
            sprintf(
                'Edited product with id : %s ',
                $product->getId()
            ),
            Response::HTTP_OK
        );
    }

    #[Route('/products/{id}/edit/stock', name: 'edit_stock_product', methods: 'PUT')]
    public function editStockProduct(
        ProductRepository $productRepository,
        Request $request,
        $id
        ): Response
    {
        $data = json_decode($request->getContent(), true);

        $product = $productRepository->find($id);
        $product->setStock($data['stock']);

        $productRepository->add($product, true);

        return new Response(
            sprintf(
                'Edited the stock of product with id : %s ',
                $product->getId()
            ),
            Response::HTTP_OK
        );
    }
}
