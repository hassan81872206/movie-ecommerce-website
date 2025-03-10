<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../index.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nationalities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <h1 style="text-align:center">Nationalities</h1>
    <?php
    require_once("../connection.php");
    $sql = "SELECT * FROM `nationalities`" ;
    $stmt = $pdo->prepare($sql) ;
    $stmt->execute();
    $nationalities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$nationalities){
        ?>
        <h3 style="color:red;text-align:center">Empty</h3>
        <?php
    }else{
        ?>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Nationalities</th>
            </tr>
            <?php
            foreach($nationalities as $nationalitie){
                ?>
                <tr>
                    <td><?php echo $nationalitie["NationalityID"] ?></td>
                    <td><?php echo $nationalitie["NationalityName"] ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    ?>
    <h1 style="text-align: center;">Add new Nationalities</h1>
    <div style="display: flex;justify-content:center;align-items:center">
        <form action="actions/addNationality.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nationalities</label>
                <input type="text" name="nationality" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <?php
            if(isset($_SESSION["addNationality"])){
                if($_SESSION["addNationality"] == true){
                    ?>
                    <p style="color:green">Added Successfully</p>
                    <?php
                }else{
                    ?>
                    <p style="color:red">Invalid Parameter</p>
                    <?php
                }
            }
            unset($_SESSION["addNationality"]);
        ?>
        </form>
    </div>
</body>
</html>