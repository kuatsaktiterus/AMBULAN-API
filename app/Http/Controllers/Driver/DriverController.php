<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        try {
            $driver = Driver::create([
                'vehicle_name'          => $request['vehicle_name'], 
                'registration_number'   => $request['registration_number'], 
                'user_id'               => $request['id'],
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $driver;
    }

    /**
     * get driver base by the id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDriver(int $id)
    {
        try {
            $driver = Driver::findOrFail($id);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $driver;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        //
    }
}
