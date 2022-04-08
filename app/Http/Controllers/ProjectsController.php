<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\Clients;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Projects::orderBy('subdomain', 'desc')->with('client', 'user')->get();
        // dd($projects);
        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'menu' => 'projects'
        ]);
    }
    public function clientProject($client_code = null){
        $client_code = base64_decode($client_code);
        $client = Clients::where('client_code', '=', $client_code)->first();
        $projects = Projects::where('client_id', $client->id)->with('client', 'user')->orderBy('subdomain', 'desc')->get();  // dd($projects);
        return Inertia::render('Clients/Projects', ['projects' => $projects, 'menu' => 'clients']);
        
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
