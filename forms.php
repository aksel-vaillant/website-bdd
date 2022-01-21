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
            $request = "UPDATE `clients` SET nameClient ='". $_POST["nameClient"] . "', ";

			$request .= "mailClient='". $_POST["mailClient"] ."', ";
			$request .= "facebook='". $_POST["facebook"] ."', ";
			$request .= "instagram='". $_POST["instagram"] ."' ";

			$request .= "WHERE codeclient='". $_POST["codeclient"]."'";

			$result = $conn->query($request);
			if($result === TRUE){
                $_SESSION["message"] = "Success! Les modifications ont bien été pris en compte.";
				header("Location: clients.php");							
			}else{
				alertFunction("Failed");
			}

            /*
            $request = "SELECT `idAddress` FROM `address` WHERE ";
            $request .= "`countryCode`='". $_POST["countryCode"] ."' AND ";
            $request .= "`cityAddress`='". $_POST["cityAddress"] ."' AND ";
            $request .= "`cityCode`='". $_POST["cityCode"] ."' AND ";
            $request .= "`streetAddress`='". $_POST["streetAddress"] ."' AND ";
            $request .= "`numAddress`='". $_POST["numAddress"] ."' AND ";
            $request .= "`phoneAddress`='". $_POST["phoneAddress"] ."'";

            echo $request;

            $result = $conn->query($request);
            $isRegistered = array();
            while($row = mysqli_fetch_array($result)){
                $isRegistered[] = $row; 
            }

            if(empty($isRegistered)){
                // Create a new address and link it to client with habite and adress 
                alertFunction("I am in");




            }else{
                // Update habite 
            }*/

            //// Delete habite et repeat datas in clients

        }
    ?>
</div>

    
</body>
</html>

