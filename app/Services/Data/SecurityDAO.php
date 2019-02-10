<?php
namespace App\Services\Data; 

use App\Models\UserModel;
use App\Services\Utility\DatabaseException;
use Illuminate\Support\Facades\Log;
use PDOException;

//BAD PRACTICE: This class really should be a UserDAO
class  SecurityDAO { 
    
    private $conn = NULL; 
    
    //BEST PRACTICE: Do not create Database Connections in a DAO so you can support Atomic Database Transactions
    public function __construct($conn) { 
        $this->conn = $conn; 
    }
    
    public function findByUser(UserModel $user) { 
        Log::info("Entering SecurityDAO.findByUser()"); 
        
        try { 
            //Select username and password and see if this row exists
            $name = $user->getUsername(); 
            $pw = $user->getPassword(); 
            $sth = $this->conn->prepare('SELECT ID, USERNAME, PASSWORD FROM USERS WHERE USERNAME = :username AND PASSWORD = :password'); 
            $sth->bindParam(':username', $name); 
            $sth->bindParam(':password', $pw); 
            $sth->execute(); 
            
            //see if user existed and return true if found else return false if not found 
            //BAD PRACTICE: This is business rules in our DAO!
            if ($sth->rowCount() == 1) { 
                Log::info("Exiting SecurityDAO.findByUser() with true"); 
                return true;
            }
            else {
                Log::info("Exiting SecurityDAO.findByUser() with false");
                return false;
            }
        } 
        catch (PDOException $e){
            //BEST PRACTICE: Catch all exceptiond (do not swallow exceptions), log the exception, do not throw technology specific exceptions, and throw a custom exception
            Log::error("Exception: ", array("message" => $e->getMessage())); 
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e); 
        }
    }
}