<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>

<?php include ('components/menu.php'); ?>

<div class="container">
    <button class="btn btn-secondary" onclick="history.back();">Retour</button>

    <?php 

        include('lib.php');
        $conn = openConnection();
        $_SESSION["message"] = "";

        // Edit a client
        if(isset($_POST["button"])){
            if($_POST["button"]=="Fiche" || $_POST["button"]=="Search a client"){

                $requestParameter = "";

                // Calc the lenght and then it's a number => request by id
                if(strlen($_POST["codeclient"]) == 11 && isInteger(substr($_POST["codeclient"], 0,2)) ){
                    $requestParameter = "`codeclient` = '". $_POST["codeclient"] ."'";
                }
                // Or it's a request by name
                else{
                    $requestParameter = "`nameClient` LIKE '%" . $_POST["codeclient"] . "%'";
                }


                $request = "SELECT `codeclient`,`nameClient`,`mailClient`,`facebook`,`instagram`,`nameMembership`,SUM(`numPoint`) AS `numPoint`, 
                            MIN(`experyPoint`) AS `experyPoint`, `idAddress`,`numAddress`,`streetAddress`,`cityAddress`,`cityCode`,`countryCode`,`phoneAddress`

                            FROM `clients` NATURAL JOIN `card` NATURAL JOIN `membership` NATURAL JOIN `points` 
                            NATURAL JOIN `cartepoint` NATURAL JOIN `habite` NATURAL JOIN `address` 
                
                            WHERE " . $requestParameter;

                $result = $conn->query($request);

                while($row = mysqli_fetch_array($result)){
                    ?>
                        <form action='forms.php' method='post'>
                            <h2>Code client n°<?php echo $row["codeclient"]; ?></h2>
                            <div class="form-group row mb-4">
                                <h5>Contact</h5>
                                <label for="nameClient" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4 mb-2">
                                <input type="text" class="form-control" name="nameClient" value="<?php echo $row['nameClient']; ?>">
                                </div>

                                <label for="phoneAddress" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" name="phoneAddress" value="<?php echo $row['phoneAddress']; ?>">
                                </div>

                                <label for="mailClient" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-4 mb-2">
                                <input type="email" class="form-control" name="mailClient" value="<?php echo $row['mailClient']; ?>">
                                </div>

                                <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" name="facebook" value="<?php echo $row['facebook']; ?>">
                                </div>

                                <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                                <div class="col-sm-4 mb-2">
                                <input type="text" class="form-control" name="instagram" value="<?php echo $row['instagram']; ?>">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <h5>Adress</h5> 
                                <label for="numAddress" class="col-sm-2 col-form-label">Street Number</label>
                                <div class="col-sm-4 mb-2">
                                <input type="text" class="form-control" name="numAddress" value="<?php echo $row['numAddress']; ?>">
                                </div>
                                <label for="streetAddress" class="col-sm-2 col-form-label">Street</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" name="streetAddress" value="<?php echo $row['streetAddress']; ?>">
                                </div>

                                <label for="cityAddress" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-2 mb-2">
                                <input type="text" class="form-control" name="cityAddress" value="<?php echo $row['cityAddress']; ?>">
                                </div>
                                <label for="cityCode" class="col-sm-2 col-form-label">ZIP Code</label>
                                <div class="col-sm-2">
                                <input type="text" class="form-control" name="cityCode" value="<?php echo $row['cityCode']; ?>">
                                </div>
                                <label for="countryCode" class="col-sm-2 col-form-label">Country Code</label>
                                <div class="col-sm-2">
                                <input type="text" class="form-control" name="countryCode" value="<?php echo $row['countryCode']; ?>">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <h5>Fidelity</h5> 
                                
                                <label for="nameMembership" class="col-sm-2 col-form-label">Membership</label>
                                <div class="col-sm-2">
                                <input type="text" class="form-control" name="nameMembership" value="<?php echo $row['nameMembership']; ?>" disabled>
                                </div>
                                
                                <label for="points" class="col-sm-2 col-form-label">Sum of their points</label>
                                <div class="col-sm-2">
                                <input type="text" class="form-control" name="points" value="<?php echo $row['numPoint']; ?>" disabled>
                                </div>
                                <label for="experyDate" class="col-sm-2 col-form-label">Expery Date</label>
                                <div class="col-sm-2">
                                <input type="date" class="form-control" name="experyDate" value="<?php echo $row['experyPoint']; ?>" disabled>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <div class="col-sm-10">
                                <input type="hidden" class="form-control" name="codeclient" value="<?php echo $row['codeclient']; ?>">
                                <input type="hidden" class="form-control" name="codeaddress" value="<?php echo $row['idAddress']; ?>">
                                <input type="submit" class="btn btn-primary" name="edit_client" value="Modifier le client"></input>
                                </div>
                            </div>
                        </form>
                    <?php
                }
            }
        }
        

        // Send the edit request to database
        if(isset($_POST["edit_client"])){
            edtClient($conn);

            // Check if the address is already resgistred or not            
            $isRegistered = isAddressRegistered($conn);

            if(empty($isRegistered)){
                // Create a new address and link it to client with habite and adress
                // Add new address
                addAddress($conn);

                // Get new address id
                $newIDaddress = getNewAddresID($conn);
                
                // Link the new address to the client
                edtHabite($conn, $newIDaddress);
                
                // Delete old address
                delHabite($conn);          
            }else{
                // Update habite
                $idAddress = $isRegistered[0]["idAddress"];

                edtHabite($conn, $idAddress);
            } 
            
            $_SESSION["message"] = "Success! Les modifications ont bien été pris en compte.";
            header("Location: clients.php");
        }

        if(isset($_POST["add_client"])){
            addClient($conn);

            // Get new client id
            $newIDclient = getNewClientID($conn);

            // Check if the address is already resgistred or not            
            $isRegistered = isAddressRegistered($conn);

            if(empty($isRegistered)){
                // Create a new address and link it to client with habite and adress
                // Add new address
                addAddress($conn);

                // Get new address id
                $newIDaddress = getNewAddresID($conn);
                
                // Link the new address to the new client
                addHabiteNewClient($conn, $newIDaddress, $newIDclient);          
            }else{
                // Update habite
                $idAddress = $isRegistered[0]["idAddress"];

                // Link the new address to the new client
                addHabiteNewClient($conn, $newIDaddress, $newIDclient);
            } 

            // Link the new card to the client
            addCard($conn, $newIDclient);

            // Get new card id
            $newIDcard = getNewCardID($conn, $newIDclient);
            
            addPoints($conn);

            // Get new points id
            $newIDpoint = getNewPointID($conn);

            addCardPoint($conn, $newIDcard, $newIDpoint);

            $_SESSION["message"] = "Success! La création du compte a bien été pris en compte.";
            header("Location: clients.php");
        }
    ?>
</div>

    
</body>
</html>

