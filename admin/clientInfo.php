<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
if(!isset($_SESSION["admin"])){
    header("location:../index.php");
    die();
}
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])){
        die("error");
    }
    $id = $_GET["id"];
    require_once("../connection.php");
    $sql = "SELECT * 
            FROM clients 
            JOIN genders ON genders.GenderID=clients.GenderID 
            JOIN countries ON countries.CountryID=clients.CountryID 
            WHERE clients.ClientID=:id" ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id" , $id);
    $stmt->execute();
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$client){
        die("error");
    }
    ?>
    <h1 style="text-align: center;">Client</h1>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Country</th>
            <th>Username</th>
        </tr>
        <tr>
            <td><?php echo $client["ClientID"]; ?></td>
            <td><?php echo $client["FName"]; ?></td>
            <td><?php echo $client["LName"]; ?></td>
            <td><?php echo $client["GenderName"]; ?></td>
            <td><?php echo $client["Phone"]; ?></td>
            <td><?php echo $client["Address"]; ?></td>
            <td><?php echo $client["CountryName"]; ?></td>
            <td><?php echo $client["Username"]; ?></td>
        </tr>
    </table>
    <h1 style="text-align: center;">Orders</h1>
    <?php
    $sql = "SELECT saledetail.SaleID,sales.saleDate,sales.ClientID,SUM(movies.UnitPrice*saledetail.Qty) as total 
            FROM saledetail 
            JOIN sales ON sales.SaleID=saledetail.SaleID 
            JOIN movies ON movies.MovieID=saledetail.MovieID 
            GROUP BY saledetail.SaleID,sales.saleDate 
            HAVING sales.ClientID=:id" ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id" , $id);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$orders){
        ?>
        <h3 style="text-align: center;color:red">Empty</h3>
        <?php
    }else{
    ?>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Total Amount</th>
        </tr>
        <?php
        foreach($orders as $order){
            ?>
            <tr>
                <td><a href="orderDetails.php?id=<?php echo $order["SaleID"]; ?>"><?php echo $order["SaleID"]; ?></a></td>
                <td><?php echo $order["saleDate"]; ?></td>
                <td><?php echo $order["total"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    }
    ?>
</body>
</html>