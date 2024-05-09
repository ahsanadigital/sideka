<?php

namespace App\Http\Controllers;

use App\Models\Council;
use App\Http\Requests\StoreCouncilRequest;
use App\Http\Requests\UpdateCouncilRequest;

class CouncilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouncilRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Council $council)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Council $council)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouncilRequest $request, Council $council)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Council $council)
    {
        //
    }
}
