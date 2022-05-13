<?php

namespace App\Http\Controllers;

use App\Models\water;
use App\Http\Requests\StorewaterRequest;
use App\Http\Requests\UpdatewaterRequest;

class WaterController extends Controller
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
     * @param  \App\Http\Requests\StorewaterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorewaterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\water  $water
     * @return \Illuminate\Http\Response
     */
    public function show(water $water)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\water  $water
     * @return \Illuminate\Http\Response
     */
    public function edit(water $water)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatewaterRequest  $request
     * @param  \App\Models\water  $water
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatewaterRequest $request, water $water)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\water  $water
     * @return \Illuminate\Http\Response
     */
    public function destroy(water $water)
    {
        //
    }
}
