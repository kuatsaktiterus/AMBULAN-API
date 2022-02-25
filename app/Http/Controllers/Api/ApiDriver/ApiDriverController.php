<?php

namespace App\Http\Controllers\Api\ApiDriver;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Services\UpdateLocationService;
use Illuminate\Http\Request;

class ApiDriverController extends Controller
{
    /**
     * get location of driver.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Http\Requests\LocationRequest  $locationReq
     * @return \Illuminate\Http\Response
     */
    public function LocationUpdate(Request $request, LocationRequest $locationReq)
    {
        $locationReq = $locationReq->validated(); 
        $userId = $request->user()->id;

        try {
            (new UpdateLocationService)->UpdateLocation($userId, $locationReq);
        } catch (\Throwable $th) {
            $this->respon('error', 'error', $th->getMessage(), null , 200);
        }

        return $this->respon('success', 'Updated Successfully', null, null , 200); 
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
