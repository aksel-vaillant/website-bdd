<?php 

function openConnection(){
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "bdd";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
    /*if (!$conn) {
        echo "Connexion à la base impossible"; 
    }else{
        echo "Connexion réussi";
    }*/
    return $conn;
 }

 function closeConnection($conn){
    $conn -> close();
}

function calculateRows($conn,$id, $fromDB){
    $request =  "SELECT COUNT(" . $id . ") FROM " . $fromDB;
    $result = $conn->query($request);
    $count = mysqli_fetch_array($result)[0];
    return $count;
}

function alertFunction($message){
    echo "<script>alert('$message');</script>";
}

function isInteger($input){
    return(ctype_digit(strval($input)));
}

// Get the list of clients
function getListClients($conn){
    $request = "SELECT `codeclient` FROM `clients`";
    $result = $conn->query($request);
    $clients = array();
    while($row =  mysqli_fetch_array($result)) { 
        $clients[] = $row[0];
    }
    return $clients;
}

// Get the list of commands
function getListCommands($conn){
    $request = "SELECT `idCommand` FROM `command`";
    $result = $conn->query($request);
    $commands = array();
    while($row =  mysqli_fetch_array($result)) { 
        $commands[] = $row[0];
    }
    return $commands;
}

// Get the list of item status
function getListItemStatus($conn){
    $request = "SELECT * FROM `itemstatus`";
    $result = $conn->query($request);
    $itemstatus = array();
    while($row =  mysqli_fetch_array($result)) {
        if($row['idStatutItem']==9){
            $itemstatus[] = "delivered";
        }else{
            $itemstatus[] = $row['typeStatusItem'];
        }
    }
    return $itemstatus;
}

// Get the list of order status
function getListOrderStatus($conn){
    $request = "SELECT * FROM `orderstatus`";
    $result = $conn->query($request);
    $orderstatus = array();
    while($row =  mysqli_fetch_array($result)) {
        $orderstatus[] = $row['typeStatut'];
    }
    return $orderstatus;
}

session_start();
//$_SESSION["message"] = "";


//session_destroy();
 
?>