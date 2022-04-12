<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $projects = Projects::where('client_id', $client->id)->with('client', 'user', 'package')->orderBy('subdomain', 'desc')->get();
        $packages = DB::table('packages')->orderBy('package_name', 'asc')->get();
        return Inertia::render('Clients/Projects', ['projects' => $projects, 'menu' => 'clients', 'user' =>auth()->user(), 'client' => $client, 'packages' => $packages]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = Projects::create([
            'client_id' => $request->client_id,
            'module_name' => $request->module_name,
            'subdomain' => $request->subdomain,
            'package_id' => $request->package_id,
            'setup_date' => $request->setup_date,
            'user_id' => auth()->user()->id,
        ]);
        return Redirect::route('/client-projects', base64_encode($request->client_code));
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
        $project = Projects::where('id', $id)->first();
        $project->module_name = $request->module_name;
        $project->subdomain = $request->subdomain;
        $project->package_id = $request->package_id;
        $project->setup_date = $request->setup_date;
        $project->save();
        return Redirect::route('/client-projects', base64_encode($request->client_code));
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
