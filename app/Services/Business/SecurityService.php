<?php
namespace App\Services\Business;

use \PDO; 
use App\Models\UserModel;
use Illuminate\Support\Facades\Log;
use App\Services\Data\SecurityDAO;

class SecurityService
{
    //TODO: 
    //REFRACTOR: This should be renamed as authenticate()
    public function login(UserModel $user) { 
        Log::info("Entering SecurityService.login()"); 
        
        //BEST PRACTICE: Externalize your app config 
        //Get credentials for accessing the database
        $servername = config("database.connections.mysql.host"); 
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        $dbname = config("database.connections.mysql.database");
        
        //BEST PRACTICE: Do not create Database connections in a DAO (so you can support Atomic Database Transactions)
        //create connection 
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        
        //Create a Security Service DAO with this connection and try to find the password in User
        $service = new SecurityDAO($conn); 
        $flag = $service->findByUser($user); 
        
        //Return the finder results 
        Log::info("Exit SecurityService.login() with " . $flag); 
        return $flag; 
    }
}

