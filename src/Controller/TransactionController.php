<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends BaseController
{


    public function __construct(EntityManagerInterface $doctrine)
    {
        parent::__construct($doctrine);
    }

    public function create(Request $request): Response
    {
        try {
            $description = $this->hasDescription($request);

            if ($description !== false) {
                return (new JsonResponse(['error' => 'duplicate description violation'], 400));
            }

            $entity = $this->factory->make($request->getContent());
            $this->doctrine->persist($entity);
            $this->doctrine->flush();
        }
        catch (Exception $exception) {
            return (new JsonResponse(['error' => $exception->getMessage()], 400));
        }
        return (new JsonResponse('', 201));
    }

    public function update(int $id, Request $request): Response
    {
        try {
            $description = $this->hasDescription($request);

            if ($description !== false) {
                return (new JsonResponse(['error' => 'duplicate description violation'], 400));
            }

            $entity = $this->repository->find($id);
            $this->factory->update($request->getContent(), $entity);

            $this->doctrine->flush();
        }
        catch (Exception $exception) {
            return (new JsonResponse(['error' => $exception->getMessage()], 400));
        }

        return (new JsonResponse('', 200));
    }

    public function hasDescription(Request $request): bool
    {
        $data = json_decode($request->getContent());

        if (isset($data->description)) {
            $description = $this->repository->findBy(['description' => $data->description]);

            if (count($description) > 0){
                return true;
            }
        }

        return false;
    }

}
