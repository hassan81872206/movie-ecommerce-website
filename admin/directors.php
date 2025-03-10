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
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1 style="text-align:center">Directors</h1>
    <?php
    require_once("../connection.php");
    $sql = "SELECT * FROM directors ;" ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $directors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$directors){
        ?>
        <h3 style="text-align:center;color:red">Empty</h3>
        <?php
    }else{
        ?>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Directors Name</th>
            </tr>
            <?php
            foreach($directors as $director){
                ?>
                <tr>
                    <td><?php echo $director["DirectorID"] ?></td>
                    <td><?php echo $director["DirectorName"] ?></td>
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