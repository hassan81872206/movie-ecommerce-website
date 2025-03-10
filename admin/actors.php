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
    <title>Actors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<h1 style="text-align:center">Actors</h1>
    <?php
    require_once("../connection.php");
    $sql = "SELECT * 
            FROM actors 
            JOIN genders ON genders.GenderID=actors.GenderID 
            JOIN nationalities ON nationalities.NationalityID=actors.NationalityID  ;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $actors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$actors){
        ?>
        <h3 style="text-align:center;color:red">Empty</h3>
        <?php
    }else{
        ?>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Actors Name</th>
                <th>Gender</th>
                <th>Nationality</th>
            </tr>
            <?php
            foreach($actors as $actor){
                ?>
                <tr>
                    <td><?php echo $actor["ActorID"] ?></td>
                    <td><?php echo $actor["ActorName"] ?></td>
                    <td><?php echo $actor["GenderName"] ?></td>
                    <td><?php echo $actor["NationalityName"] ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    ?>
    <div style="display:flex;justify-content:center;align-items:center">
        <form action="actions/addActor.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Actor Name</label>
                <input type="text" name="actor" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <p>Gender</p>
            <select name="gender" class="form-select" aria-label="Default select example">
                <?php
                $sql = "SELECT * FROM `genders`;" ;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $genders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($genders as $gender){
                    ?>
                    <option value="<?php echo $gender['GenderID'];?>"><?php echo $gender["GenderName"];?></option>
                    <?php
                }
                ?> 
            </select>
            <p>Nationality</p>
            <select name="nationality" class="form-select" aria-label="Default select example">
                <?php
                $sql = "SELECT * FROM `nationalities`;" ;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $nationalities = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($nationalities as $nationalitie){
                    ?>
                    <option value="<?php echo $nationalitie['NationalityID'];?>"><?php echo $nationalitie["NationalityName"];?></option>
                    <?php
                }
                ?> 
            </select>
            <button type="submit" class="btn btn-primary">Submit</button>
            <?php
            if(isset($_SESSION["addActor"])){
                if($_SESSION["addActor"] == true){
                    ?>
                    <p style="color:green">Added Successfully</p>
                    <?php
                }else{
                    ?>
                    <p style="color:red">Invalid Parameter</p>
                    <?php
                }
            }
            ?>
        </form>    
    </div>
</body>
</html>