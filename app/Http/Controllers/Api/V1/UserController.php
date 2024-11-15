<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $dataArray = $request->validate([
            'per_page' => 'integer|min:1'
        ]);
        return new UserCollection(User::where('role', '=', 'employee')->filter()->latest()->paginate(empty($dataArray) ? 10 : (int)$dataArray['per_page']));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(StoreUserRequest $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        return new UserResource($User);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(User $User)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateUserRequest $request, User $User)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(User $User)
    // {
    //     //
    // }
}
