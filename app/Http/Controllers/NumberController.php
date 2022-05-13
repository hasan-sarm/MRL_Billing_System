<?php

namespace App\Http\Controllers;

use App\Models\number;
use App\Http\Requests\StorenumberRequest;
use App\Http\Requests\UpdatenumberRequest;

class NumberController extends Controller
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
     * @param  \App\Http\Requests\StorenumberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorenumberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\number  $number
     * @return \Illuminate\Http\Response
     */
    public function show(number $number)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\number  $number
     * @return \Illuminate\Http\Response
     */
    public function edit(number $number)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenumberRequest  $request
     * @param  \App\Models\number  $number
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatenumberRequest $request, number $number)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\number  $number
     * @return \Illuminate\Http\Response
     */
    public function destroy(number $number)
    {
        //
    }
}
