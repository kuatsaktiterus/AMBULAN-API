<?php

namespace App\Http\Controllers\Order\OrderAcceptedLog;

use App\Http\Controllers\Controller;
use App\Models\OrderAcceptedLog;
use Illuminate\Http\Request;

class OrderAcceptedLogController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        try {
            $OrderAccLog = OrderAcceptedLog::create([
                'order_id' => $request['order_id'],
                'driver_id' => $request['driver_id'],
            ]);
        } catch (\Throwable $th) {
            return $this->respon('error', 'error', $th->getMessage(), null , 500); 
        }
        return $OrderAccLog;
    }
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        try {
            $OrderAccLog = OrderAcceptedLog::findOrFail($id);
            $OrderAccLog->update([
                $OrderAccLog->order_id  = $request['order_id'],
                $OrderAccLog->driver_id = $request['driver_id'],
                $OrderAccLog->is_accepted = $request['is_accepted'],
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $OrderAccLog;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
