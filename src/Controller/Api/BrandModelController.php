<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;

class BrandModelController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route(path: '/api/brandsmodels', name: "api_brandsmodels", methods: ['GET'])]
    public function getAllBrandModels(BrandRepository $brandRepository): Response
    {
        $brands = $brandRepository->findAll(); // Fetch all brands

        // For each brand, fetch its associated models
        $brandModelsData = [];
        foreach ($brands as $brand) {
            $brandModelsData[] = [
                'brand' => $brand->getName(),
                'models' => $brand->getModel()->toArray() // Get associated models as an array
            ];
        }

        $context = SerializationContext::create()->setGroups(['getBrand', 'getModel']);
        $jsonBrandModels = $this->serializer->serialize($brandModelsData, 'json', $context);

        return new JsonResponse($jsonBrandModels, Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/brands', name: "api_brands_index", methods: ['GET'])]
    public function getAllBrands(BrandRepository $brandRepository): Response
    {
        $brands = $brandRepository->findAll();
        $context = SerializationContext::create()->setGroups("getBrand");
        $jsonBrands = $this->serializer->serialize($brands, 'json', $context);

        return new JsonResponse($jsonBrands, Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/models', name: "api_models_index", methods: ['GET'])]
    public function getAllModels(ModelRepository $modelRepository): Response
    {
        $models = $modelRepository->findAll();
        $context = SerializationContext::create()->setGroups("getModel");
        $jsonModels = $this->serializer->serialize($models, 'json', $context);

        return new JsonResponse($jsonModels, Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/models/{brand}', name: "api_brand_models", methods: ['GET'])]
    public function getModelsByBrand(string $brand, BrandRepository $brandRepository): Response
    {
        $brand = $brandRepository->findOneBy(['name' => $brand]);

        if (!$brand) {
            return new JsonResponse(['error' => 'Brand not found'], Response::HTTP_NOT_FOUND);
        }

        $models = $brand->getModel();
        $context = SerializationContext::create()->setGroups("getModel");
        $jsonModels = $this->serializer->serialize($models, 'json', $context);

        return new JsonResponse($jsonModels, Response::HTTP_OK, [], true);
    }

    #[Route(path: '/api/brand/{model}', name: "api_model_brands", methods: ['GET'])]
    public function getBrandByModel(string $model, ModelRepository $modelRepository): Response
    {
        $model = $modelRepository->findOneBy(['name' => $model]);

        if (!$model) {
            return new JsonResponse(['error' => 'Model not found'], Response::HTTP_NOT_FOUND);
        }

        $brand = $model->getBrand();
        $context = SerializationContext::create()->setGroups("getBrand");
        $jsonBrand = $this->serializer->serialize($brand, 'json', $context);

        return new JsonResponse($jsonBrand, Response::HTTP_OK, [], true);
    }
}
