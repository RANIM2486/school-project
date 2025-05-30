<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reason;

class ReasonController extends Controller
{
    public function index()
{
    return Reason::all();
}
}
