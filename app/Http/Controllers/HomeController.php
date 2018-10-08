<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FacebookController;
use Auth;



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
        $this->fb = new FacebookController();
        $this->middleware('auth');
    }


    // public function index(Request $request)
    // {
    //     # code...

    //     $headers = array('Content-Type' => 'json');
    //     $data = array('title'=>'ExploreSocialMedia','message'=>'explore your business with SocialMedia');
    //     return response()->json($data,200,$headers);
    // }

     public function index(Request $request)
    {
        $todo = Auth::user()->facebook_accounts()->get();
        return response()->json(['status' => 'success','result' => $todo]);
    }

     public function facebook_login()
    {
        # code...
            $login_url = $this->fb->loginUrl();
            return redirect()->to($login_url);
    }

    public function facebook_redirect(Request $request)
    {
        # code...
        try{
        $output = $pages = $profile  = array();
        $headers = array('Content-Type' => 'json');
        $output = $request->input();
        
        if(!isset($output['code']))
        throw new Exception("Error Processing Facebook Login Request", 1);
        
        app('session')->put('FBRLH_state', $output['state']);
        // die(print_r(app('session')->get('FBRLH_state')));
        // FB_ACCESS_TOKEN();
        $this->fb->accessToken();

        $access_token = app('session')->get('fb_token');
        if(!$access_token)
        throw new Exception("Faceboook token not found", 1);

         $reponse = $this->fb->fb->get('/me?fields=id,name,email', $access_token);
         $profile = @json_decode($reponse->getBody());

        $data = array('status'=>'success','data'=>$profile);
        return response()->json($data,200,$headers);
        }
        catch(Exception $e){
        return response()->json(array('status'=>'error','message'=>$e->getMessage()),200,$headers);
        }
    }

    //
}
