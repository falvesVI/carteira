<?php

namespace App\Controller;

use App\Factory\Factory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{

    protected ObjectRepository $repository;
    protected Factory $factory;
    protected EntityManagerInterface $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function index(): Response
    {
        try {
            $entitys = $this->repository->findAll();
        }
        catch (Exception $exception) {
            return (new JsonResponse(['error' => $exception->getMessage()], 400));
        }

        return (new JsonResponse($entitys, "200"));
    }

    public function create(Request $request): Response
    {
        try {

            $entity = $this->factory->make($request->getContent());

            $this->doctrine->persist($entity);

            $this->doctrine->flush();
        }
        catch (Exception $exception) {
            return (new JsonResponse(['error' => $exception->getMessage()], 400));
        }

        return (new JsonResponse('', 201));
    }

    public function delete(int $id): Response
    {
        try {

            $entity = $this->repository->find($id);

            if ($entity === null) {
                return (new JsonResponse('', 204));
            }

            $this->doctrine->remove($entity);
            $this->doctrine->flush();
        }
        catch (Exception $exception) {
            return (new JsonResponse(['error' => $exception->getMessage()], 400));
        }

        return (new JsonResponse('', 200));
    }

    public function findById(int $id)
    {
        try {
            $entity = $this->repository->find($id);

            if ($entity === null) {
                return (new JsonResponse('', 204));
            }
        }
        catch (Exception $exception) {
            return (new JsonResponse(['error' => $exception->getMessage()], 400));
        }

        return (new JsonResponse($entity, 200));
    }

    public function update(int $id, Request $request): Response
    {
        $entity = $this->repository->find($id);
        $this->factory->update($request->getContent(), $entity);

        try {
            $this->doctrine->flush();
        }
        catch (Exception $exception) {
            return (new JsonResponse(['error' => $exception->getMessage()], 400));
        }

        return (new JsonResponse('', 200));
    }

}

