<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CounterResource;
use App\Http\Resources\V1\CounterCollection;
use App\Http\Requests\V1\StoreCounterRequest;
use App\Http\Requests\V1\UpdateCounterRequest;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataArray = $request->validate([
            'per_page' => 'integer|min:1'
        ]);

        $counter = Counter::filter();
        $counter = $counter->with(['service', 'user']);

        return new CounterCollection($counter->latest()->paginate(empty($dataArray) ? 10 : (int)$dataArray['per_page']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCounterRequest $request)
    {
        return new CounterResource(Counter::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Counter $counter)
    {
        $counter->load(['service', 'user']);
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
        $counter->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Counter $counter)
    {
        Counter::destroy($counter->id);
    }
}
