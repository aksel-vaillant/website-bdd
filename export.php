<?php 

include("lib.php");

$conn = openConnection();

// Excel file name for download
$fileName = "commandsData_" . date("Y-m-d") . ".xls"; 

// Column names
$fields = array("Code Command", "Code Client", "Order Date", "Items", "Payment", "Order Status", "Note");

// Display column names as first row
$excelData = implode("\t", array_values($fields)) . "\n";

// Get the list of commands
$commands = getListCommands($conn);

// Get the list of item status
$itemstatus = getListItemStatus($conn);

// Get the list of order status
$orderstatus = getListOrderStatus($conn);

// For each command, do a request with all the data from the command and items
foreach($commands as $command){

    $request = "SELECT * FROM `command` NATURAL JOIN `linkorder` WHERE `idCommand` = '".$command."'";
    $result = $conn->query($request);
    while($row =  mysqli_fetch_array($result)) {
        $dateOrder = (isset($row['dateOrder'])) ? $row['dateOrder'] : "";
        $sumTotal = 0;
        $descItem = '=CONCAT(';

        $request1 = "SELECT * FROM compose as c NATURAL JOIN item INNER JOIN linkitem USING(idItem) INNER JOIN linkorder USING(idCommand) WHERE c.idCommand='".$row['idCommand']."'";
        $result1 = $conn->query($request1);
        while($row1 =  mysqli_fetch_array($result1)) {
            $sumTotal += $row1["qtyItem"] * $row1["puItem"];
            $descItem .= '"' . $row1["qtyItem"] . "x ". $row1['nameItem']." (".$itemstatus[$row1["idStatutItem"]-1].')"; '. "CHAR(10) ;";
        }                            
        
        $descItem .= ")";

        $lineData = array($row['idCommand'], $row['codeClient'], $dateOrder,$descItem ,$sumTotal, $orderstatus[$row['idStatut']],$row['noteOrder']);
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

echo $excelData;

//header("Location: commands.php");

?>