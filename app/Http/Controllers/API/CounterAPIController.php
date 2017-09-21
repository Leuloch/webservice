<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCounterAPIRequest;
use App\Http\Requests\API\UpdateCounterAPIRequest;
use App\Models\Counter;
use App\Repositories\CounterRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CounterController
 * @package App\Http\Controllers\API
 */

class CounterAPIController extends AppBaseController
{
    /** @var  CounterRepository */
    private $counterRepository;

    public function __construct(CounterRepository $counterRepo)
    {
        $this->counterRepository = $counterRepo;
    }

    /**
     * Display a listing of the Counter.
     * GET|HEAD /counters
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->counterRepository->pushCriteria(new RequestCriteria($request));
        $this->counterRepository->pushCriteria(new LimitOffsetCriteria($request));
        $counters = $this->counterRepository->all();

        return $this->sendResponse($counters->toArray(), 'Counters retrieved successfully');
    }

    /**
     * Store a newly created Counter in storage.
     * POST /counters
     *
     * @param CreateCounterAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCounterAPIRequest $request)
    {
        $input = $request->all();
        $input['ip_address'] = $this->get_client_ip_server();

        $counters = $this->counterRepository->create($input);


        return $this->sendResponse($counters->toArray(), 'Counter saved successfully');
    }

    /**
     * Display the specified Counter.
     * GET|HEAD /counters/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Counter $counter */
        $counter = $this->counterRepository->findWithoutFail($id);

        if (empty($counter)) {
            return $this->sendError('Counter not found');
        }

        return $this->sendResponse($counter->toArray(), 'Counter retrieved successfully');
    }

    /**
     * Update the specified Counter in storage.
     * PUT/PATCH /counters/{id}
     *
     * @param  int $id
     * @param UpdateCounterAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCounterAPIRequest $request)
    {
        $input = $request->all();

        /** @var Counter $counter */
        $counter = $this->counterRepository->findWithoutFail($id);

        if (empty($counter)) {
            return $this->sendError('Counter not found');
        }

        $counter = $this->counterRepository->update($input, $id);

        return $this->sendResponse($counter->toArray(), 'Counter updated successfully');
    }

    /**
     * Remove the specified Counter from storage.
     * DELETE /counters/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Counter $counter */
        $counter = $this->counterRepository->findWithoutFail($id);

        if (empty($counter)) {
            return $this->sendError('Counter not found');
        }

        $counter->delete();

        return $this->sendResponse($id, 'Counter deleted successfully');
    }

    private function get_client_ip_server() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;        
    }
}
