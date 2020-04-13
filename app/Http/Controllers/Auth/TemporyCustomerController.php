<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemporyCustomerController extends Controller
{
    
    public function index()
    {
        $user_type = "Tempory";
        return view('auth.tempory_customer',compact('user_type')); 
    }
}
