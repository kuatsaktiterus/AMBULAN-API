<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Driver;
use App\Services\UpdateLocationDriverService;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Http\Requests\LocationRequest  $locationReq
     * @return \Illuminate\Http\Response
     */
    public function LocationUpdate(Request $request, LocationRequest $locationReq)
    {
        $updateLocation = new UpdateLocationDriverService;
        $locationReq = $locationReq->validated(); 
        $userId = $request->user()->id;

        $update = $updateLocation->UpdateLocationDriver($userId, $locationReq);

        return ($update[0]) ? $this->respon('success', 'Updated Successfully', null, null , 200) :
        $this->respon('error', 'error', $update[1]->getMessage(), null , 200); 
    }

    /**
     * get driver base by the id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDriver(int $id)
    {
        $driver = Driver::findOrFail($id);

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
