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
    <title>Movie Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])){
        die("error");
    }
    $id = $_GET["id"] ;
    ?>
    <h1 style="text-align:center">Categories</h1>
    <?php
    require_once("../connection.php");
    $sql = "SELECT categories.CategoryName 
            FROM moviecategories 
            JOIN categories ON categories.CategoryID=moviecategories.CategoryID 
            WHERE moviecategories.MovieID=:id" ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id" ,$id);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table class="table table-striped">
        <tr>
            <th>Category Name</th>
        </tr>
        <?php
        foreach($categories as $categorie){
            ?>
            <tr>
                <td><?php echo $categorie["CategoryName"] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <h1 style="text-align:center">Actors</h1>
    <?php
    require_once("../connection.php");
    $sql = "SELECT actors.ActorName 
            FROM movieactors 
            JOIN actors ON actors.ActorID=movieactors.ActorID 
            WHERE movieactors.MovieID=:id" ;
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id" ,$id);
    $stmt->execute();
    $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table class="table table-striped">
        <tr>
            <th>Actor Name</th>
        </tr>
        <?php
        foreach($actors as $actor){
            ?>
            <tr>
                <td><?php echo $actor["ActorName"] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</body>
</html>