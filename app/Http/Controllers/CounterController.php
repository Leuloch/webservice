<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCounterRequest;
use App\Http\Requests\UpdateCounterRequest;
use App\Repositories\CounterRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CounterController extends AppBaseController
{
    /** @var  CounterRepository */
    private $counterRepository;

    public function __construct(CounterRepository $counterRepo)
    {
        $this->counterRepository = $counterRepo;
    }

    /**
     * Display a listing of the Counter.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->counterRepository->pushCriteria(new RequestCriteria($request));
        $counters = $this->counterRepository->all();

        return view('counters.index')
            ->with('counters', $counters);
    }

    /**
     * Show the form for creating a new Counter.
     *
     * @return Response
     */
    public function create()
    {
        return view('counters.create');
    }

    /**
     * Store a newly created Counter in storage.
     *
     * @param CreateCounterRequest $request
     *
     * @return Response
     */
    public function store(CreateCounterRequest $request)
    {
        $input = $request->all();

        $counter = $this->counterRepository->create($input);

        Flash::success('Counter saved successfully.');

        return redirect(route('counters.index'));
    }

    /**
     * Display the specified Counter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $counter = $this->counterRepository->findWithoutFail($id);

        if (empty($counter)) {
            Flash::error('Counter not found');

            return redirect(route('counters.index'));
        }

        return view('counters.show')->with('counter', $counter);
    }

    /**
     * Show the form for editing the specified Counter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $counter = $this->counterRepository->findWithoutFail($id);

        if (empty($counter)) {
            Flash::error('Counter not found');

            return redirect(route('counters.index'));
        }

        return view('counters.edit')->with('counter', $counter);
    }

    /**
     * Update the specified Counter in storage.
     *
     * @param  int              $id
     * @param UpdateCounterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCounterRequest $request)
    {
        $counter = $this->counterRepository->findWithoutFail($id);

        if (empty($counter)) {
            Flash::error('Counter not found');

            return redirect(route('counters.index'));
        }

        $counter = $this->counterRepository->update($request->all(), $id);

        Flash::success('Counter updated successfully.');

        return redirect(route('counters.index'));
    }

    /**
     * Remove the specified Counter from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $counter = $this->counterRepository->findWithoutFail($id);

        if (empty($counter)) {
            Flash::error('Counter not found');

            return redirect(route('counters.index'));
        }

        $this->counterRepository->delete($id);

        Flash::success('Counter deleted successfully.');

        return redirect(route('counters.index'));
    }
}
