<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function userMain()
    {
        return view('front.user-offers.index');
    }

    public function userOfferPage()
    {
        return view('front.user-offers.offer-page');
    }

    public function userOfferSubmit(Request $req)
    {
        dd($req->all());

        return view('front.user-offers.offer-page');
    }

}
