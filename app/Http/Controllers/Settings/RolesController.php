<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    //
    public function index()
    {
        // Logic to list roles
        return view('pages.settings.roles.index');
    }
}
