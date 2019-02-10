<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Services\Business\SecurityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class Login2Controller extends Controller
{
    public function index(Request $request) { 
        try{    
            //get the posted form data 
            $username = $request->input('username'); 
            $password = $request->input('password'); 
            
            //save posted form data in user object model 
            $user = new UserModel(-1, $username, $password);
            
            //Call Security Business Service 
            $service = new SecurityService(); 
            $status = $service->login($user); 
            
            //render a failed or success response view and pass the User Model to it 
            if($status) { 
                $Data = ['model' => $user];
                return view('loginPassed2')->with($Data); 
            }
            else { 
                return view('loginFailed2'); 
            }
        }catch (Exception $e){
            //BEST PRACTICE: Catch all exceptions, log the exception, and display a common Error page(or use a global exception page)
            Log::error("Exception: ", array("message" =>$e->getMessage())); 
            $Data = ['errorMsg'=>$e->getMessage()]; 
            return view('exception')->with($Data); 
        }
               
    }
}
