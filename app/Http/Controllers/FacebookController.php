<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Facebook\Facebook;


class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void

     */

    
    public function __construct()
    {
        //
        $this->fb = new Facebook([
            'app_id' => FACEBOOK_APP_ID,
            'app_secret' => FACEBOOK_APP_SECRET,
            'default_graph_version' => 'v2.2'
        ]);
    }


    public function loginUrl()
    {
        # code...
         $helper = $this->fb->getRedirectLoginHelper();
        $permissions = explode(",", FACEBOOK_PERMISSIONS);
        $loginUrl = $helper->getLoginUrl(PATH.'facebook/redirect', $permissions);
        return $loginUrl;
    }

    public function accessToken()
    {
        # code...
        $fb = $this->fb;
        $helper= $fb->getRedirectLoginHelper();

        try {
                $accessToken = $helper->getAccessToken();
              // Access token will be null if the user denied the request
              // or if someone just hit this URL outside of the OAuth flow.
              if (! $accessToken) {
                  // Get the redirect helper
                  if (! $helper->getError())
                      abort(403, 'Unauthorized action.');
                
                  // User denied the request
                  // dd(
                  //     $helper->getError(),
                  //     $helper->getErrorCode(),
                  //     $helper->getErrorReason(),
                  //     $helper->getErrorDescription()
                  // );
            return array('status'=>'error','message'=>$helper->getErrorDescription());
              }

              if (! $accessToken->isLongLived()) {


                  // OAuth 2.0 client handler
                  $oauth_client = $fb->getOAuth2Client();

                  // Extend the access token.
                $accessToken = $oauth_client->getLongLivedAccessToken($accessToken);
              }

              $fb->setDefaultAccessToken($accessToken);

              app('session')->put('fb_token',$accessToken);
    
                $response = $fb->get('/me?fields=id,name,email');

                $data = array('fb_access_token'=>$accessToken,'response'=>$response);

            return array('status'=>'success','data'=>$data);

          } catch(Facebook\Exceptions\FacebookResponseException $e) {

            // When Graph returns an error
            return array('status'=>'error','message'=>'Graph returned an error: '.$e->getMessage());

        } catch(Facebook\Exceptions\FacebookSDKException $e) {

            // When validation fails or other local issues
            return array('status'=>'error','message'=>'Facebook SDK returned an error: '.$e->getMessage());
        }

    }

  
    //
}
