<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../index.php");
    die();
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Admin Dachboard
    </title>
    <style>
        .container{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 60px;
        }
        .links a{
            color: black;
            text-decoration: none;
            padding: 5px;
        }
        .links a:hover{
            color: gold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dachboard</h1>
        <div class="links">
            <a href="clients.php">clients</a>
            <a href="categories.php">Categories</a>
            <a href="actors.php">Actors</a>
            <a href="directors.php">Directors</a>
            <a href="movies.php">Movies</a>
            <a href="gender.php">Genders</a>
            <a href="nationality.php">Nationalities</a>
        </div>
    </div>
</body>
</html>