<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Counter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CounterCollection;
use App\Http\Requests\V1\StoreCounterRequest;
use App\Http\Requests\V1\UpdateCounterRequest;
use App\Http\Resources\V1\CounterResource;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CounterCollection(Counter::paginate(10));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCounterRequest $request)
    {
        return new CounterResource(Counter::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Counter $counter)
    {
        return new CounterResource($counter);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Counter $counter)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCounterRequest $request, Counter $counter)
    {
        $counter->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Counter $counter)
    {
        Counter::destroy($counter->id);
    }
}
