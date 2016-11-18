<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PaaController extends Controller
{
    //
    public function index()
	{
		return view('configuracionPAA');
	}
	public function proyecto()
	{
		return view('proyecto');
	}
}
