<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>

<?php include ('components/menu.php'); ?>

<div class="container">
    <button class="btn btn-secondary mt-5" onclick="history.back();">Back</button>

    <?php 

        include('lib.php');
        $conn = openConnection();
        $_SESSION["message"] = "";

        // Edit a client
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
                    <div class="card card-body mt-3">
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
                    </div>
                <?php
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

        // Send the adding request to database
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

        if($_POST["button"]=="Consulter" || $_POST["button"] == "Search a command" || $_POST["button"] == "Supprimer" || $_POST["button"] == "Ajouter un article existant" || $_POST["button"] == "Creer une Commande" || $_POST["button"] == "Modifier commande"){

            if ($_POST["button"] == "Supprimer" && isset($_POST["idItemDel"])){
                $request = "DELETE FROM `compose` WHERE idCommand='".$_POST["idCommand"]."' AND idItem = ".$_POST["idItemDel"].";";
                $conn->query($request);
            }

            if ($_POST["button"] == "Ajouter un article existant" ){
                $request = "INSERT INTO `compose` (`idCommand`,`idItem`, `qtyItem`, `puItem`) VALUES ('".$_POST["idCommand"]."',".$_POST["articleExistant"].", '".$_POST["quantite"]."', '".$_POST["puItem"]."');";
                $conn->query($request);
                
            }

            if($_POST["button"] == "Modifier commande" && isset($_POST["desc"])){
                $request = "UPDATE command set noteOrder ='".$_POST["desc"]."' WHERE idCommand = '".$_POST["idCommand"]."';";
                $conn->query($request);
            }

            $requestParameter = "";

            // Calc the lenght and then it's a number => request by id
            if(isset($_POST["idCommand"])){
                if(strlen($_POST["idCommand"]) >= 18){
                    $requestParameter = "`idCommand` = '". $_POST["idCommand"] ."'";
                    $idCommand = $_POST['idCommand'];
                }
            }else if ($_POST['button'] ==  "Creer une Commande"){
                $request = "SELECT Count(idCommand) as nb from command";
                $res = $conn->query($request);
                $row = mysqli_fetch_array($res);

                $var = date('jmY');
                $var .= "-CMD-C";
                $var .= sprintf("%'.04d",$row['nb']+1);
                $codeClient = $_POST['client'];
                $idCommand = $var;

                $request = "INSERT INTO Command (idCommand, noteOrder, codeClient) VALUES('".$var."','','".$codeClient."');";
                $result = $conn->query($request);

                $request = "INSERT INTO linkorder (dateStatut, idStatut, idCommand) VALUES('".date('Y-m-j')."',1,'".$idCommand."');";
                $result = $conn->query($request);

                $requestParameter = "`idCommand` = '".$idCommand."';";
            }

            $request = "SELECT * FROM `compose` NATURAL JOIN `item` WHERE ". $requestParameter.";";
            $result = $conn->query($request);

            ?>
                <table class="table table-striped">
                <h2 class="mt-3 mb-3">Code commande n°<?php echo $idCommand; ?></h2>
                <caption>Liste des articles</caption>
                <thead bgcolor="black">
                    <tr>
                        <th scope="col">Code article</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix Unitaire</th>
                        <th scope="col">Nom de l'article</th>
                        <th scope="col">Note de l'article</th>
                        <th scope="col">Prix unitaire Ref</th>
                        <th scope="col">Status Article</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

            <?php 
            if ($result != false){
                while($row =  mysqli_fetch_array($result)) {
                    echo '<tr>';
                        $idCommand = $row['idCommand'];
                        echo '<td scope="col">'.$row['idItem'].'</td>';
                        echo '<td scope="col">'.$row['qtyItem'].'</td>';
                        echo '<td scope="col">'.$row['puItem'].' €</td>';
                        echo '<td scope="col">'.$row['nameItem'].'</td>';
                        echo '<td scope="col">'.$row['descItem'].'</td>';
                        echo '<td scope="col">'.$row['puItemRef'].' €</td>';
                        echo '<td scope="col">'.mysqli_fetch_array($conn->query("SELECT typeStatusItem FROM itemstatus WHERE idStatutItem = (SELECT idStatutItem FROM linkitem WHERE idItem =".$row['idItem'].");"))['typeStatusItem'].'</td>';
                        echo "<td scope='col'><form action='forms.php' method='post'><input type='hidden' class='form-control' name='idItemDel' value ='".$row['idItem']."'>";
                        echo '<input type="submit" class="btn btn-danger" name="button" value="Supprimer"></td>';
                    echo('</tr>');
                }
            }
            
            echo "</table>";
        ?>

            <div class="card card-body">
                <form action='forms.php' method="post">
                    <?php
                            $request = "SELECT * FROM item;";
                            $result = $conn->query($request);
                    ?>

                    <div class="form-group row mb-2">
                        <h5 class="mb-3">Existing articles</h5>
                        <label for="articleExistant" class="col-sm-1 col-form-label  mb-2">Items</label>
                        
                        <div class="form-group col-sm-3">
                            <select name="articleExistant" id="articleExistant" class="col-sm-6 form-control">
                            <?php         
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value=".$row['idItem'].">".$row['nameItem']." -- ".$row['puItemRef']." €</option>";
                                }
                            ?>
                            </select>
                        </div>

                        <label for="puItem" class="col-sm-2 col-form-label">Prix unitaire (en €)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="puItem" value="0" min="0" step="0.01">
                        </div>

                        <label for="quantite" class="col-sm-2 col-form-label">Quantité</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="quantite" value="1" min="0">
                        </div>
                    </div>
                            
                    <div class="form-group row mb-3">
                        <div class="col-sm-2">
                        <input type="hidden" class="form-control" name="idCommand" value="<?php echo $idCommand; ?>">
                        <input type="submit" class="btn btn-primary" name="button" value="Ajouter un article existant"></input>
                        </div>
                    </div>
                </form>

                <h5>Edit description</h5>
                <form action="forms.php" method="post">

                    <div class="form-group row mb-12">
                        <label for="desc" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-12 mb-3">
                            <?php 
                                $request = "SELECT `noteOrder` FROM `command` WHERE `idCommand` = '". $idCommand."'";
                                $result = $conn->query($request);
                                while($row =  mysqli_fetch_array($result)) {
                                    echo "<input type='text' class='form-control'  name='desc' value='".$row["noteOrder"]."'>";
                                }
                            ?>
                        </div>

                        <div class="col-sm-2">
                            <input type="hidden" class="form-control" name="idCommand" value="<?php echo $idCommand;?>">
                            <input type="submit" class="btn btn-primary" name="button" value="Modifier commande">
                        </div>
                    </div>
                </form>
            </div>
            
            

            <?php   
        }

        if ($_POST["button"] == "Ajouter un article"){

            if ($_POST["button"] == "Ajouter un article" && isset($_POST['nameItem']) && isset($_POST['desc']) && isset($_POST['puItem']) ){
                $request = "INSERT INTO `item` (`idItem`, `nameItem`, `descItem`, `puItemRef`) VALUES (DEFAULT, '".$_POST["nameItem"]."', '".$_POST["desc"]."', '".$_POST["puItem"]."');";
                $conn->query($request);

                $request = "SELECT max(idItem) as nb FROM item;";
                $res = $conn->query($request);
                $row = mysqli_fetch_array($res);

                $request = "INSERT INTO `linkitem` (`dateStatut`,`idItem`,`idStatutItem`) VALUES ('".date('Y-m-j')."',".$row['nb'].",".$_POST['Statuts'].");";
                $conn->query($request);
            }

            ?>
            <form action='forms.php' method='post'>
                <div class="form-group row mb-4">
                    <h2 class="mt-2 mb-3">Ajouter un item</h2>
                    <h5>Item</h5>
                    <label for="nameItem" class="col-sm-2 col-form-label">Nom de l'article :</label>
                    <div class="col-sm-4 mb-2">
                    <input type="text" class="form-control" name="nameItem" value="">
                    </div>

                    <label for="puItem" class="col-sm-2 col-form-label">Prix unitaire Ref :</label>
                    <div class="col-sm-4">
                    <input type="number" class="form-control" name="puItem" value="0" min="0" step="0.01">
                    </div>

                    <label for="desc" class="col-sm-2 col-form-label">Note :</label>
                    <div class="col-sm-4 mb-2">
                    <input type="text" class="form-control" name="desc" value="">
                    </div>

                    <label for="quantite" class="col-sm-2 col-form-label">Quantité :</label>
                    <div class="col-sm-4">
                    <input type="number" class="form-control" name="quantite" value="1" min="0">
                    </div>

                    <label for="statuts" class="col-sm-4 col-form-label">Statut :</label>
                    <div class="form-group col-sm-2 mb-4">
                    <select name="Statuts" id="statuts" class="form-control">
                    <?php
                        $request = "SELECT * FROM `itemstatus`;";
                        $result = $conn->query($request);
                        while($row =  mysqli_fetch_array($result)) {
                            echo "<option value=".$row["idStatutItem"].">".$row["typeStatusItem"]."</option>";
                        }
                    ?>    
                    </select>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                        <input type="submit" class="btn btn-primary" name="button" value="Ajouter un article"></input>
                        </div>
                    </div>
                </div>
            </form>
    <?php
        }
    
    ?>
</div>

    
</body>
</html>

