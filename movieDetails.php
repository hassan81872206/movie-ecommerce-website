<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_GET["movieID"]) && !empty(trim($_GET["movieID"])) && is_numeric($_GET["movieID"])){
        $movieID = trim($_GET["movieID"]);
        require_once("connection.php");
        $sql = "SELECT MovieID FROM movies" ;
        $stmt = $pdo->prepare($sql) ;
        $stmt->execute();
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $moviesArray = [] ;
        foreach($movies as $movie){
            $moviesArray[] = $movie["MovieID"] ;
        }
        if(!in_array($movieID , $moviesArray)){
            die("error");
        }
        $sql = "SELECT * FROM movies WHERE MovieID = :id" ;
        $stmt = $pdo->prepare($sql) ;
        $stmt->bindParam(":id" , $movieID) ;
        $stmt->execute();
        $movieAll = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$movieAll){
            die("error");
        }
        ?>
        <div style="display:flex; flex-direction:column">
            <img width="200px" height="200px" src="<?php echo $movieAll["images"]; ?>" alt="">
            <span>Title : <?php echo $movieAll["Title"]; ?></span>
            <span>Year : <?php echo $movieAll["ProduceYear"]; ?></span>
            <span>Price : <?php echo $movieAll["UnitPrice"]; ?></span>
            <?php
            $sql = "SELECT * FROM directors WHERE DirectorID = :id" ;
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id" , $movieAll["DirectorID"]);
            $stmt->execute();
            $directorName = $stmt->fetch(PDO::FETCH_ASSOC); 
            ?>
            <span>Director :<?php echo $directorName["DirectorName"]; ?></span>
            <?php
            $sql = "SELECT * 
                    FROM categories 
                    JOIN moviecategories ON categories.CategoryID=moviecategories.CategoryID 
                    WHERE moviecategories.MovieID = :movieID;" ;
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":movieID" , $movieAll["MovieID"]);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$categories){
                echo '<p> None </p>';
            }else{
                foreach($categories as $categorie){
                    ?>
                    <span> Categorie : <?php echo $categorie["CategoryName"]; ?></span>
                    <?php
                }
            } 
            
             $sql = "SELECT * 
                    FROM actors 
                    JOIN movieactors ON movieactors.ActorID=actors.ActorID 
                    WHERE movieactors.MovieID=:movieID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":movieID" , $movieAll["MovieID"]);
            $stmt->execute();
            $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!$actors){
                echo '<p> None </p>';
            }else{
                foreach($actors as $actor){
                    ?>
                    <span> Actor : <?php echo $actor["ActorName"]; ?></span>
                    <?php
                }
            } 
            ?>
            <form action="actions/addToCard.php" method="POST">
                <input type="hidden" name="movieID" value="<?php echo $movieAll["MovieID"] ?>">
                <input type="submit" >
            </form>
        </div>
        <?php
    
    }
    ?>
</body>
</html>