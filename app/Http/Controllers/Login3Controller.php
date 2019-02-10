<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Services\Business\SecurityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;


class Login3Controller extends Controller
{
    public function index(Request $request) { 
        try{    
            //validate the form data 
            $this->validateForm($request); 
            
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
                return view('loginPassed3')->with($Data); 
            }
            else { 
                return view('loginFailed3'); 
            }
        }
        
        catch(ValidationException $e1) {
            throw $e1;
        }
        
        catch (Exception $e){
            //BEST PRACTICE: Catch all exceptions, log the exception, and display a common Error page(or use a global exception page)
            Log::error("Exception: ", array("message" =>$e->getMessage())); 
            $Data = ['errorMsg'=>$e->getMessage()]; 
            return view('exception')->with($Data); 
        }
               
    }
    
    private function validateForm(Request $request) {
        //setup data validattion rules
        $rules = ['username' => 'Required | Between: 4,10| Alpha','password' => 'Required | Between: 4,10'];
        
        //run data validation rules
        $this->validate($request, $rules);
    }
}
