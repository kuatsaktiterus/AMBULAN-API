<?php

namespace App\Http\Controllers;

use App\Models\OrderAcceptedLog;
use App\Http\Requests\StoreOrderAcceptedLogRequest;
use App\Http\Requests\UpdateOrderAcceptedLogRequest;

class OrderAcceptedLogController extends Controller
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
     * @param  \App\Http\Requests\StoreOrderAcceptedLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderAcceptedLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderAcceptedLog  $orderAcceptedLog
     * @return \Illuminate\Http\Response
     */
    public function show(OrderAcceptedLog $orderAcceptedLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderAcceptedLog  $orderAcceptedLog
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderAcceptedLog $orderAcceptedLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderAcceptedLogRequest  $request
     * @param  \App\Models\OrderAcceptedLog  $orderAcceptedLog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderAcceptedLogRequest $request, OrderAcceptedLog $orderAcceptedLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderAcceptedLog  $orderAcceptedLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderAcceptedLog $orderAcceptedLog)
    {
        //
    }
}
