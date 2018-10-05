<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function index()
    {
        # code...
        $data = array('title'=>'ExploreSocialMedia','message'=>'explore your business with SocialMedia');
        $headers  = array('Content-Type' => 'json');
        return response()->json($data,200,$headers);
    }

     public function facebook_login()
    {
        # code...
            return redirect()->to(FB_LOGIN_CONNECT());
    }

    public function facebook_redirect()
    {
        # code...
        print_r($_GET);
    }

    //
}
