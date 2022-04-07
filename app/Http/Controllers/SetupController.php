<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Cpanel\cPanelController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class SetupController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $data = [];

    public function __construct()
    {
          $this->data['packages'] = ['XDesign360', 'Biroev360'];
          $this->data['menu'] = 'setup';
    }

    public function index()
    {
        return Inertia::render('Wizard/Index', $this->data);

    }

}
