<?php

namespace App\Infrastructure\Controller\Activity;

use Exception;
use App\Exception\ActivitySorterException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Activity\Add\AddActivityServiceRequest;
use App\Application\Activity\Add\AddActivityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Activity\SportsActivity\Add\AddSportsActivityServiceRequest;
use App\Application\Activity\AdventureActivity\Add\AddAdventureActivityServiceRequest;
use App\Application\Activity\OnlineGameActivity\Add\AddOnlineGameActivityServiceRequest;

class AddActivityController extends AbstractController
{
    /** @var AddActivityServiceInterface[] */
    private array $addActivityServices;

    public function __construct(array $addActivityServices)
    {
        $this->addActivityServices = $addActivityServices;
    }

    public function add(Request $request): Response
    {
        try {
            $addActivityServiceRequest = $this->buildRequest($request);
            if (!\array_key_exists($request->get('type', ''), $this->addActivityServices)) {
                throw new ActivitySorterException('Add for type ' . $request->get('type') . 'not implemented');
            }
            $message = $this->json([
                'id' => $this->addActivityServices[$request->get('type')]->add($addActivityServiceRequest)
            ]);
        } catch(ActivitySorterException $e) {
            $message = $this->json($e->getMessage(), $e->getCode() === 0 ? 500 : $e->getCode());
        } catch(Exception $e) {
            $message = $this->json('An error has ocurred.', 500);
        }

        return $message;
    }

    private function buildRequest(Request $request): AddActivityServiceRequest
    {
        switch ($request->get('type')) {
            case 'adventure_activity':
                $addActivityServiceRequest = new AddAdventureActivityServiceRequest(
                    $request->get('name', ''),
                    $request->get('description', ''),
                    $request->get('equipments', [])
                );
                break;
            case 'online_game_activity':
                $addActivityServiceRequest = new AddOnlineGameActivityServiceRequest(
                    $request->get('name', ''),
                    $request->get('description', ''),
                    $request->get('platform', '')
                );
                break;
            case 'sports_activity':
                $addActivityServiceRequest = new AddSportsActivityServiceRequest(
                    $request->get('name', ''),
                    $request->get('description', ''),
                    $request->get('sports_type', '')
                );
                break;
            default:
                throw new ActivitySorterException('Type to add not supported: ' . $request->get('type'));
        }

        return $addActivityServiceRequest;
    }
}
