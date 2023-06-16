<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\QuotationController;
use Exception;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $JWT_TOKEN = env('JWT_SECRET');
        return View::make('home',compact('JWT_TOKEN'));
    }
}
