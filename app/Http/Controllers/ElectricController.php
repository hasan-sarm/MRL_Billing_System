<?php

namespace App\Http\Controllers;

use App\Models\electric;
use App\Http\Requests\StoreelectricRequest;
use App\Http\Requests\UpdateelectricRequest;

class ElectricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreelectricRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreelectricRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\electric  $electric
     * @return \Illuminate\Http\Response
     */
    public function show(electric $electric)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\electric  $electric
     * @return \Illuminate\Http\Response
     */
    public function edit(electric $electric)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateelectricRequest  $request
     * @param  \App\Models\electric  $electric
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateelectricRequest $request, electric $electric)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\electric  $electric
     * @return \Illuminate\Http\Response
     */
    public function destroy(electric $electric)
    {
        //
    }
}
