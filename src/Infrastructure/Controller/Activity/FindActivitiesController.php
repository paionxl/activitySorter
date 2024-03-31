<?php

namespace App\Infrastructure\Controller\Activity;

use Exception;
use App\Exception\ActivitySorterException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Activity\Find\FindActivitiesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Activity\Find\FindActivitiesServiceRequest;

class FindActivitiesController extends AbstractController
{
    private FindActivitiesServiceInterface $findActivitiesService;

    public function __construct(FindActivitiesServiceInterface $findActivitiesService)
    {
        $this->findActivitiesService = $findActivitiesService;
    }

    public function find(Request $request): Response
    {
        try {
            $findActivitiesServiceRequest = $this->buildRequest($request);

            $message = $this->json(
                $this->findActivitiesService->find($findActivitiesServiceRequest)->getActivities()
            );
        } catch(ActivitySorterException $e) {
            $message = $this->json($e->getMessage(), $e->getCode() === 0 ? 500 : $e->getCode());
        } catch(Exception $e) {
            $message = $this->json('An error has ocurred.', 500);
        }

        return $message;
    }

    private function buildRequest(Request $request): FindActivitiesServiceRequest
    {
        $findActivitiesServiceRequest = new FindActivitiesServiceRequest();
        $findActivitiesServiceRequest->setType($request->get('type', ''));
        $findActivitiesServiceRequest->setName($request->get('name', ''));
        $findActivitiesServiceRequest->setDescription($request->get('description', ''));
        $findActivitiesServiceRequest->setEquipment($request->get('equipment', ''));
        $findActivitiesServiceRequest->setPlatform($request->get('platform', ''));
        $findActivitiesServiceRequest->setSportsType($request->get('sports_type', ''));

        return $findActivitiesServiceRequest;
    }
}
