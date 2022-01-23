<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Commands</title>
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
    <h2 class="mt-5">Order files</h2>

    <div class="col-md-12 head mb-2">
        <div class="float-right">
            <a href="export.php" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1h-2z"/>
                    <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                </svg>
                Export</a>
        </div>
    </div>

    <div class="row">
        
        <!--Affichage des commandes + requêtages-->
        <table class="table table-striped">
            <caption>Order files</caption>
            <thead bgcolor="black">
                <tr>
                    <th scope="col">Code Command</th>
                    <th scope="col">Code Client</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Items</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Order status</th>
                    <th scope="col">Note</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $conn = openConnection();

                    // Get the list of commands
                    $commands = getListCommands($conn);

                    // Get the list of item status
                    $itemstatus = getListItemStatus($conn);

                    // Get the list of order status
                    $orderstatus = getListOrderStatus($conn);


                    // For each command, do a request with all the data from the command and items
                    foreach($commands as $command){

                        $request = "SELECT *
                                    FROM `command` NATURAL JOIN `linkorder` 
                                    WHERE `idCommand` = '".$command."'";

                        $result = $conn->query($request);

                        while($row =  mysqli_fetch_array($result)) { 
                            echo '<tr>';
                            echo '<td scope="col">'.$row['idCommand'].'</td>';
                            echo '<td scope="col">'.$row['codeClient'].'</td>';

                            if(isset($row['dateOrder']))
                                echo "<td scope='col'>". $row['dateOrder'] ."</td>";
                            else
                                echo "<td scope='col'></td>";


                            echo '<td scope="col">';
                            $request1 = "SELECT * FROM compose as c NATURAL JOIN item INNER JOIN linkitem USING(idItem) INNER JOIN linkorder USING(idCommand) WHERE c.idCommand='".$row['idCommand']."'";
                            $result1 = $conn->query($request1);

                            $sumTotal = 0;
                            while($row1 =  mysqli_fetch_array($result1)) {
                                echo '<div class="row">'.$row1["qtyItem"].'x '.$row1['nameItem'].' ('.$itemstatus[$row1["idStatutItem"]-1].')</div>';
                                $sumTotal += $row1["qtyItem"] * $row1["puItem"];
                            }                            
                            echo '</td>';

                            echo '<td scope="col">'.$sumTotal.'€</td>';
                            echo '<td scope="col">'.$orderstatus[$row['idStatut']].'</td>';
                            echo '<td scope="col">'.$row['noteOrder'].'</td>';
                            ?>

                            <form action='forms.php' method='post'>
                                <td>
                                    <!-- Allows the identification of the client-->                                     
                                    <input type='hidden' name='idCommand' value='<?php echo $row["idCommand"];?>'>
                                    <input type='submit' name='button' class="btn btn-primary" value='Consulter'/>                                    
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
        
        <h5>Create an order</h5>
        <!--Ajout d'un commande pour un client + requêtages-->
        <div class="card card-body mb-4">
            <form action='forms.php' method='post'>
                <?php
                    $clients = getListClients($conn);
                ?>

                <div class="form-group col-sm-6">
                    <label for="membership" class="col-sm-6 col-form-label  mb-2">Client's ID</label>

                    <select name="client" id="client" class="col-sm-6 form-control mb-4" >
                        <?php
                            foreach($clients as $client){
                                echo "<option value=".$client.">".$client."</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" class="btn btn-primary" name="button" value="Creer une Commande"></input>
                </div>
            </form>
        </div>

        <h5>Add a new item</h5>
        <!--Ajout d'un commande pour un client + requêtages-->
        <div class="card card-body">
            <form action='forms.php' method='post' class="form mb-2">
                <input type="submit" class="btn btn-primary" name="button" value="Ajouter un article"></input>
            </form>
        </div>
        
    </div>



</div>

    
</body>
</html>