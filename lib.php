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


/************************************/
/************************************/
//     ENSEMBLE DES REQUETES SQL
//      + gestion des erreurs 
/************************************/
/************************************/


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
        $itemstatus[] = $row['typeStatusItem'];
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

// Add a client
function addClient($conn){
    $request = "INSERT INTO `clients` (`codeclient`, `nameClient`, `mailClient`, `facebook`, `instagram`)
                VALUES (";

    $idClient = "" . substr( date("Y"), -2) ."-SPR-".str_pad(calculateRows($conn, "`codeclient`", "`clients`") + 1, 4, "0", STR_PAD_LEFT )."";

    $request .= "'". $idClient . "',";
    $request .= "'". $_POST["nameClient"] . "',";
    $request .= "'". $_POST["mailClient"] . "',";
    $request .= "'". $_POST["facebook"] . "',";
    $request .= "'". $_POST["instagram"] . "')";
    
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in adding client");
    }
}

// Edit a client
function edtClient($conn){
    $request = "UPDATE `clients` SET nameClient ='". $_POST["nameClient"] . "', ";
    $request .= "mailClient='". $_POST["mailClient"] ."', ";
    $request .= "facebook='". $_POST["facebook"] ."', ";
    $request .= "instagram='". $_POST["instagram"] ."' ";
    $request .= "WHERE codeclient='". $_POST["codeclient"]."'";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in edit client");
    }
}

// Get a client id with $_POST datas
function getNewClientID($conn){
    // Get new address id
    $request = "SELECT `codeClient` FROM `clients` WHERE ";
    $request .= "`nameClient`='". $_POST["nameClient"] ."' AND ";
    $request .= "`mailClient`='". $_POST["mailClient"] ."' AND ";
    $request .= "`facebook`='". $_POST["facebook"] ."' AND ";
    $request .= "`instagram`='". $_POST["instagram"] ."'";
    $result = $conn->query($request);
    $newIDclient = "";
    while($row = mysqli_fetch_array($result)){
        $newIDclient = $row["codeClient"]; 
    }
    return $newIDclient;
}

// Add a card
function addCard($conn, $idClient){
    $request = "INSERT INTO `card` (`idCard`, `codeClient`, `idMembership`)
                VALUES ('DEFAULT',";
    $request .= "'". $idClient . "',";
    $request .= "'". $_POST["membership"] . "')";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in adding card");
    }
}

// Get the last ID card created
function getNewCardID($conn, $idClient){
    $request = "SELECT `idCard` FROM `card` WHERE ";
    $request .= "`codeClient`='". $idClient ."'";
    $result = $conn->query($request);

    $newIDcard = "";
    while($row = mysqli_fetch_array($result)){
        $newIDcard = $row["idCard"]; 
    }
    return $newIDcard;
}

// Add points with an expery date
function addPoints($conn){
    $request = "INSERT INTO `points` (`idPoints`, `numPoint`, `experyPoint`)
                VALUES ('DEFAULT',";
    $request .= "'". $_POST["points"] . "',";
    $request .= "'". $_POST["experyDate"] . "')";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in adding points");
    }
}

// Get the last ID point created 
function getNewPointID($conn){
    return calculateRows($conn, "idPoints", "`points`");
}

// Add points to the card
function addCardPoint($conn, $idCard, $idPoints){
    $request = "INSERT INTO `cartepoint` (`idCard`, `idPoints`) VALUES (";
    $request .= "'". $idCard . "',";
    $request .= "'". $idPoints . "')";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in adding points on card");
    }
}

// Check if an adress is already registered in the database with $_POST datas
function isAddressRegistered($conn){
    $request = "SELECT `idAddress` FROM `address` WHERE ";
    $request .= "`countryCode`='". $_POST["countryCode"] ."' AND ";
    $request .= "`cityAddress`='". $_POST["cityAddress"] ."' AND ";
    $request .= "`cityCode`='". $_POST["cityCode"] ."' AND ";
    $request .= "`streetAddress`='". $_POST["streetAddress"] ."' AND ";
    $request .= "`numAddress`='". $_POST["numAddress"] ."' AND ";
    $request .= "`phoneAddress`='". $_POST["phoneAddress"] ."'";
    $result = $conn->query($request);
    $isRegistered = array();
    while($row = mysqli_fetch_array($result)){
        $isRegistered[] = $row;
    }
    return $isRegistered;
}

// Add an address
function addAddress($conn){
    $request = "INSERT INTO `address` (`idAddress`, `countryCode`, `cityAddress`, `cityCode`, `streetAddress`, `numAddress`,`phoneAddress`)
                VALUES ('DEFAULT',";
    $request .= "'". $_POST["countryCode"] . "',";
    $request .= "'". $_POST["cityAddress"] . "',";
    $request .= "'". $_POST["cityCode"] . "',";
    $request .= "'". $_POST["streetAddress"] . "',";
    $request .= "'". $_POST["numAddress"] . "',";
    $request .= "'". $_POST["phoneAddress"] . "')";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in adding address");
    }
}

// Get ID address by $_POST datas
function getNewAddresID($conn){
    // Get new address id
    $request = "SELECT `idAddress` FROM `address` WHERE ";
    $request .= "`countryCode`='". $_POST["countryCode"] ."' AND ";
    $request .= "`cityAddress`='". $_POST["cityAddress"] ."' AND ";
    $request .= "`cityCode`='". $_POST["cityCode"] ."' AND ";
    $request .= "`streetAddress`='". $_POST["streetAddress"] ."' AND ";
    $request .= "`numAddress`='". $_POST["numAddress"] ."' AND ";
    $request .= "`phoneAddress`='". $_POST["phoneAddress"] ."'";
    $result = $conn->query($request);
    $newIDaddress = "";
    while($row = mysqli_fetch_array($result)){
        $newIDaddress = $row["idAddress"]; 
    }
    return $newIDaddress;
}

// Add a "habite" with $_POST data with a codeclient
function addHabite($conn, $newIDaddress){
    $request ="INSERT INTO `habite` (`codeclient`, `idAddress`) VALUES (";
    $request .= "'". $_POST["codeclient"] ."',";
    $request .= "'". $newIDaddress."')";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in linking address with client");
    }
}

// Add a "habite" with ID client
function addHabiteNewClient($conn, $newIDaddress, $idClient){
    $request ="INSERT INTO `habite` (`codeclient`, `idAddress`) VALUES (";
    $request .= "'". $idClient ."',";
    $request .= "'". $newIDaddress."')";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in linking address with client");
    }
}

// Delete a "habite" => a client can have only one address =====> but, an address can be link to n client(s)
function delHabite($conn){
    $request = "DELETE FROM `habite` WHERE `codeclient`='".$_POST["codeclient"]."' AND ";
    $request .= "`idAddress`='".$_POST["codeaddress"]."'";
    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in deleting address");
    }
    return $result;
}

// Edit a "habite" with the ID of the new created address 
function edtHabite($conn, $idAddress){
    $request = "UPDATE `habite` SET idAddress ='". $idAddress . "' ";
    $request .= "WHERE `codeClient`='". $_POST["codeclient"] ."'";

    $result = $conn->query($request);
    if($result == FALSE){
        alertFunction("Failed in edit habite");
    }
}

session_start();
//$_SESSION["message"] = "";


//session_destroy();
 
?>