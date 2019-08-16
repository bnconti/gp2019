<?php
/*
 * User Class
 * This class is used for database related (connect, insert, and update) operations
 * @author    CodexWorld.com
 * @url        http://www.codexworld.com
 * @license    http://www.codexworld.com/license
 */

class User {
    private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName     = "gdp";
    private $userTbl    = "users";
    
    function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }

    function getUserLocal($userData = array()){
        if(!empty($userData)){
            // Check whether user data already exists in the database
            $checkUserLocal = "SELECT * FROM usuarios WHERE gmail = '".$userData['email']."'";
            // Get user data from the database
            $result = $this->db->query($checkUserLocal);
            $userLocal = $result->fetch_assoc();
        }
        
        // Return user data
        return $userLocal;
    }
    
    function checkUser($userData = array()){
        if(!empty($userData)){
            // Check whether user data already exists in the database
            $checkQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
            $checkUserLocal = "SELECT * FROM usuarios WHERE gmail = '".$userData['email']."'";
            $checkResult = $this->db->query($checkQuery);
            $checkResultUser = $this->db->query($checkUserLocal);
            if($checkResult->num_rows > 0){
                // Update user data if already exists
                $query = "UPDATE ".$this->userTbl." SET first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', modified = NOW() WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);
            }else{
                // Insert user data in the database
                $query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', created = NOW(), modified = NOW()";
                $query2 = "INSERT INTO usuarios SET mail_itt = '".$userData['first_name'].$userData['last_name']."@unnoba.edu.ar', gmail = '".$userData['email']."', rol = 'rol', cargo = 'cargo', dedicacion = 'dedicacion', aceptado = 0";
                $insert = $this->db->query($query);
                $insert = $this->db->query($query2);
            }
            
            // Get user data from the database
            $result = $this->db->query($checkQuery);
            $userData = $result->fetch_assoc();
        }
        
        // Return user data
        return $userData;
    }

    function setUserLocal($userData = array(), $matchGmail){
        if(!empty($userData)){
            // Check whether user data already exists in the database
            $checkUserLocal = "UPDATE usuarios SET mail_itt='".$userData['mail_itt']."', rol='".$userData['rol']."', cargo='".$userData['cargo']."', dedicacion='".$userData['dedicacion']."' WHERE gmail = '".$matchGmail."'";
            // Update user data from the database
            $this->db->query($checkUserLocal);
        }
    }
}
