<?php

namespace App\Http\Controllers;

use App\Models\Data as ModelsData;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class Data extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = User::where('device_id',$request->v55)->first();
        ModelsData::create([
            'user_id' => $user->id,
            'bpm' => $request->bpm,
        ]);

        return response()->json($request->all(),200);
    }
    public function storeLocation(Request $request)
    {
        Location::updateOrCreate([
            'user_id' => $request->user_id
        ],[
            'lat' => $request->lat,
            'long' => $request->lon
        ]);
        return response()->json('success', 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ModelsData::where('user_id',$id)->orderBy('id','DESC')->first();
        return response()->json($data,200);
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
