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
    <title>Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        h1{
            text-align: center;
        }
        .search{
            display: flex;
            justify-content: center;
            padding: 10px;
        }
        .search form input[type="text"]{
            border-radius:20px ;
            width: 350px;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h1>Clients</h1>
    <div class="search">
        <form action="clients.php" method="GET">
            <input type="text" name="search" placeholder="search...">
            <input type="submit">
        </form>
    </div>
    <?php
    require_once("../connection.php");
    $number_of_clients_in_page = 3 ;
    $sql = "SELECT COUNT(clients.ClientID) 'total' FROM clients;" ;
    $stmt = $pdo->query($sql);
    $total_number_of_clients = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_number_of_clients = $total_number_of_clients["total"];
    $number_of_pages = ceil($total_number_of_clients/$number_of_clients_in_page) ; //4.1 = 5 or 9.2 = 10
    if(isset($_GET["page"]) && !empty($_GET["page"]) && is_numeric($_GET["page"])){
        $limit = ($_GET["page"] - 1) * $number_of_clients_in_page ;
    }else{
        $limit = 0 ;
    }
    if(isset($_GET["search"]) && !empty($_GET["search"])){
        $search = $_GET["search"];
        $search = "%$search%";
        $sql = "SELECT * FROM clients WHERE clients.FName LIKE :search OR clients.LName LIKE :search;" ; 
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":search" , $search);
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $sql = "SELECT clients.ClientID,clients.FName,clients.LName,clients.Phone FROM clients LIMIT :limit,$number_of_clients_in_page";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":limit",$limit,PDO::PARAM_INT);
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    if(!$clients){
        echo "nothing" ; 
    }else{
        ?>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
            </tr>
            <?php
            foreach($clients as $client){
                ?>
                <tr>
                    <th><a href="clientInfo.php?id=<?php echo $client['ClientID']?>"><?php echo $client["ClientID"];?></a></th>
                    <th><?php echo $client["FName"]; ?></th>
                    <th><?php echo $client["LName"]; ?></th>
                    <th><?php echo $client["Phone"]; ?></th>
                </tr>
            <?php    
            }
            ?>
        </table>
        <?php
        for($page = 1 ; $page <= $number_of_pages ; $page++){
            ?>
            <a href="clients.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            <?php
        }
    }
    ?>
</body>
</html>