<?php
session_start();
if(!isset($_SESSION["login"])){
    header("location:../login.php");
    die();
}
if(isset($_POST["movieID"]) && !empty(trim($_POST["movieID"])) && is_numeric($_POST["movieID"])){
    $id = trim($_POST["movieID"]);
    require_once("../connection.php");
    $sql = "SELECT MovieID FROM movies";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $moviesID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arrayMovies = [];
    foreach($moviesID as $movieID){
        $arrayMovies[] = $movieID["MovieID"];
    }
    if(!in_array($id , $arrayMovies)){
        die("error");
    }
    $sql = "SELECT * FROM sales WHERE ClientID=:userID AND Opened = 1 ;" ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userID" , $_SESSION["user"]);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    $saleID = $order["SaleID"];
    if(!$order){
        $sql = "INSERT INTO `sales` (`ClientID`, `saleDate`, `Opened`) VALUES (:userID, current_timestamp(), '1');";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":userID" , $_SESSION["user"]);
        $stmt->execute();
        $saleID = $pdo->lastInsertId();
        $sql = "INSERT INTO `saledetail` (`SaleID`, `MovieID`, `Qty`) VALUES ($saleID, :movieID, '1');" ;
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":movieID" , $id);
        $stmt->execute();
        $_SESSION["msg"] = "Added Successfuly" ;
        header("location:../index.php");
        die();
    }else{
        $sql = "SELECT * FROM saledetail WHERE saledetail.SaleID=:saleID And saledetail.MovieID=:movieID" ;
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":saleID" , $saleID);
        $stmt->bindParam(":movieID" , $id);
        $stmt->execute();
        $sale = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$sale){
            $sql = "INSERT INTO `saledetail` (`SaleID`, `MovieID`, `Qty`) VALUES ($saleID, :movieID, '1');" ;
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":movieID" , $id);
            $stmt->execute();
            $_SESSION["msg"] = "Added Successfuly" ;
            header("location:../index.php");
            die();
        }else{
            $sql = "UPDATE saledetail 
                    set saledetail.Qty = saledetail.Qty+1 
                    WHERE saledetail.MovieID=:movieID AND saledetail.SaleID =:saleID" ;
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":movieID" , $id);
            $stmt->bindParam(":saleID" , $saleID);
            $stmt->execute();
            $_SESSION["msg"] = "Added" ;
            header("location:../index.php");
            die();        
        }
    }
}else{
    die("error Parameter");
}