<?php

namespace App\Http\Controllers;

use App\Models\Decree;
use App\Http\Requests\StoreDecreeRequest;
use App\Http\Requests\UpdateDecreeRequest;
use Illuminate\Http\Request;

class DecreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {}

        return view('page.panel.decree');
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
    public function store(StoreDecreeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Decree $decree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Decree $decree)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDecreeRequest $request, Decree $decree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Decree $decree)
    {
        //
    }
}
