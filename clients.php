<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="style.css" rel="stylesheet">    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>
<body>

<?php 
    include('lib.php'); 
    include ('components/menu.php');
?>



<div class="container">
    <h2 class="mt-5">Gestion des clients</h2>

    <div class="col-md-12 head mb-2">
            <div class="float-right">
                <a href="#" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1h-2z"/>
                        <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                    </svg>
                    Export</a>
            </div>
    </div>

    <div class="row">
        

        <!--Affichage des clients + requêtages-->
        <table class="table table-striped">
            <caption>Liste des clients</caption>
            <thead bgcolor="black">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Adress</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Membership</th>
                    <th scope="col">Points</th>
                    <th scope="col">Expery Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $conn = openConnection();

                    // Get the list of clients
                    $clients = getListClients($conn);

                    // For each client, do a request with all the data from the client
                    foreach($clients as $client){
                        $request = "SELECT `codeclient`,`nameClient`,`mailClient`,`nameMembership`,SUM(`numPoint`) AS `numPoint`, 
                                    MIN(`experyPoint`) AS `experyPoint`, `cityAddress`,`cityCode`,`countryCode`,`phoneAddress`

                                    FROM `clients` NATURAL JOIN `card` NATURAL JOIN `membership` NATURAL JOIN `points` 
                                    NATURAL JOIN `cartepoint` NATURAL JOIN `habite` NATURAL JOIN `address` 
                                    
                                    WHERE `codeclient` = '".$client."'";
                        $result = $conn->query($request);
                        while($row =  mysqli_fetch_array($result)) { 
                            echo '<tr>';
                            echo '<td scope="col">'.$row['codeclient'].'</td>';
                            echo '<td scope="col">'.$row['nameClient'].'</td>';
                            echo '<td scope="col">'.$row['mailClient'].'</td>';
                            echo '<td scope="col">'.$row['cityAddress'].' ['.$row['countryCode'].']'.'</td>';
                            echo '<td scope="col">'.$row['phoneAddress'].'</td>';
                            echo '<td scope="col">'.$row['nameMembership'].'</td>';
                            echo '<td scope="col">'.$row['numPoint'].'</td>';
                            echo '<td scope="col">'.$row['experyPoint'].'</td>';
                            ?>

                            <form action='forms.php' method='post'>
                                <td>
                                    <!-- Allows the identification of the client-->                                     
                                    <input type='hidden' name='codeclient' value='<?php echo $row["codeclient"];?>'>
                                    <input type='submit' name='button' class="btn btn-primary" value='Fiche'/>                                    
                                </td>
                            </form>

                            <?php
                            echo '</tr>';
                        }
                    }
                    /*
                   */
                ?>
            </tbody>
        </table>

        
    </div>




   
    <h4>Formulaire d'incription</h4>

    <!--Ajout d'un client + requêtages-->
    <div class="card card-body">
        <form action="forms.php" method="post">
            <div class="form-group row mb-4">
                <h5>Contact</h5>
                <label for="nameClient" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-4  mb-2">
                <input type="text" class="form-control" name="nameClient">
                </div>

                <label for="phoneAddress" class="col-sm-2 col-form-label">Phone Number</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" name="phoneAddress">
                </div>

                <label for="mailClient" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-4  mb-2">
                <input type="email" class="form-control" name="mailClient">
                </div>

                <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" name="facebook">
                </div>

                <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                <div class="col-sm-4  mb-2">
                <input type="text" class="form-control" name="instagram">
                </div>
            </div>

            <div class="form-group row mb-4">
                <h5>Adress</h5> 
                <label for="numAddress" class="col-sm-2 col-form-label">Street Number</label>
                <div class="col-sm-4  mb-2">
                <input type="text" class="form-control" name="numAddress">
                </div>
                <label for="streetAddress" class="col-sm-2 col-form-label">Street</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" name="streetAddress">
                </div>

                <label for="cityAddress" class="col-sm-2 col-form-label">City</label>
                <div class="col-sm-2  mb-2">
                <input type="text" class="form-control" name="cityAddress">
                </div>
                <label for="cityCode" class="col-sm-2 col-form-label">ZIP Code</label>
                <div class="col-sm-2">
                <input type="text" class="form-control" name="cityCode">
                </div>
                <label for="countryCode" class="col-sm-2 col-form-label">Country Code</label>
                <div class="col-sm-2">
                <input type="text" class="form-control" name="countryCode">
                </div>
            </div>

            <div class="form-group row">
                <h5>Fidelity</h5> 
                <label for="membership" class="col-sm-2 col-form-label  mb-2">Membership</label>
                
                <div class="form-group col-sm-2">
                    <select name="membership" class="form-control">
                        <option value="1" selected>Silver</option>
                        <option value="2" disabled>Gold</option>
                        <option value="3" disabled>Platinium</option>
                        <option value="4">Ultimate</option>
                    </select>
                </div>
                
                <label for="points" class="col-sm-2 col-form-label">Points</label>
                <div class="col-sm-2">
                <input type="text" class="form-control" name="points" value="0">
                </div>
                <label for="experyDate" class="col-sm-2 col-form-label">Expery Date</label>
                <div class="col-sm-2">
                <input type="date" class="form-control" name="experyDate">
                </div>
            </div>

            
            <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" name="add_client" class="btn btn-primary">Créer un compte client</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let message = "<?php echo $_SESSION["message"];?>";
    if(message != ""){
        alert(message);
    }
</script>

</body>
</html>