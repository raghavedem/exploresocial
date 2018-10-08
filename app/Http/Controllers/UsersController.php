<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
/**
 * 
 */
class UsersController extends Controller
{
    
    function __construct()
    {
        # code...
    }

    public function authenticate(Request $request)
    {
        try{
        $data = array();
        // $apikey = '123456';
        $user = User::where('email', $request->input('email'))->first();
        if(sizeof($user) == 0)
            throw new Exception("'Invalid Credentials'", 1);
        
        $pass_check = ($request->input('password') != $user->password)?true:false;
        // $pass_check = Hash::check($request->input('password'), $user->password);
        if($pass_check)
            throw new Exception("Invalid Password", 1);
           
            $data['api_key'] = str_random(40);

         User::where('email', $request->input('email'))->update($data);    
        return response()->json(array('status'=>'success','data'=>$data));
        }
        catch(Exception $e){
        return response()->json(array('status'=>'error','message'=>$e->getMessage()));
        }
      

    }


}
 ?>