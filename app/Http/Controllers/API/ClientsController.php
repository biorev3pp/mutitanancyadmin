<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'client_code' => 'required|unique:clients' 
        ]);
        Clients::create([
            'name' => $request->name,
            'email' => $request->email,
            'client_code' => $request->client_code,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ]);
        return ['success'];
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
        $client = Clients::where('id', $id)->first();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,'.$request->id,
        ]);
        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ]);
        return ['success'];
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
