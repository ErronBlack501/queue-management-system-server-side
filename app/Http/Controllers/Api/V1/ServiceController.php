<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreServiceRequest;
use App\Http\Resources\V1\ServiceResource;
use App\Http\Requests\V1\UpdateServiceRequest;
use App\Http\Resources\V1\ServiceCollection;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ServiceCollection(Service::paginate(10));
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
    public function store(StoreServiceRequest $request)
    {
        return new ServiceResource(Service::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {

        return new ServiceResource($service);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Service $service)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        Service::destroy($service->id);
    }
}
