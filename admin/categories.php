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
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    require_once("../connection.php");
    ?>
    <h1 style="text-align:center">Categories</h1>
    <?php
    require_once("../connection.php");
    $sql = "SELECT * FROM categories ;" ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$categories){
        ?>
        <h3 style="text-align:center;color:red">Empty</h3>
        <?php
    }else{
        ?>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Categories Name</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            <?php
            foreach($categories as $categorie){
                ?>
                <tr meta-cat="<?php echo $categorie["CategoryID"]; ?>">
                    <td><?php echo $categorie["CategoryID"] ?></td>
                    <td><?php echo $categorie["CategoryName"] ?></td>
                    <td>
                    <!-- <td><form action="actions/deleteCategory.php" method="POST"> -->
                        <!-- <input type="hidden" name="id" value="<?php echo $categorie["CategoryID"]; ?>" id=""> -->
                        <button type="button" onclick="deletee(<?php echo $categorie['CategoryID']; ?>)" class="btn btn-danger">Delete</button>
                    <!-- </form></td> -->
                    </td>
                    <td><form action="updateCategorie.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $categorie["CategoryID"]; ?>">
                        <input type="hidden" name="categorie" value="<?php echo $categorie["CategoryName"]; ?>">
                        <input type="submit" value="Update" class="btn btn-primary">
                    </form></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    if(isset($_SESSION["deleteCategory"])){
        if($_SESSION["deleteCategory"] == true){
            ?>
            <p style="color:green">Delete Successfully</p>
            <?php
        }else{
            ?>
            <p style="color:red">Invalid Parameter</p>
            <?php
        }
    }
    if(isset($_SESSION["updateCategorie"])){
        if($_SESSION["updateCategorie"] == true){
            ?>
            <p style="color:green">Update Successfully</p>
            <?php
        }else{
            ?>
            <p style="color:red">Invalid Parameter</p>
            <?php
        }
    }
    unset($_SESSION["deleteCategory"]);
    unset($_SESSION["updateCategorie"]);
    ?>
    <h1 style="text-align:center">Add New Categories</h1>
        <div style="display:flex;justify-content:center;align-items:center;">
            <form action="actions/addCategories.php" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Enter New Categories</label><br>
                    <input name="categories" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter New Categories"><br>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <?php
                if(isset($_SESSION["addCategorie"])){
                    if($_SESSION["addCategorie"] === true){
                        ?>
                        <p style="color:green">Added Successfully</p>
                        <?php
                    }else{
                        ?>
                        <p style="color:red">Invalid Input</p>
                        <?php
                    }
                }
                unset($_SESSION["addCategorie"]);
                ?>
            </form>
        </div>
</body>
<script>
    function deletee(id){
        console.log(id);

        const urlencoded = new URLSearchParams();
        urlencoded.append("id", id);

        const requestOptions = {
        method: "POST",
        body: urlencoded,
        };

        fetch("http://localhost/media/admin/actions/deleteCategory.php", requestOptions)
        .then((response) => response.json())
        .then((result) => getDataDelete(result,id))
        .catch((error) => console.error(error));
    }
    function getDataDelete(result,id){
        if(result.success){
            let cat = document.querySelector(`tr[meta-cat='${id}']`);
            cat.remove();
            // console.log(cat);
        }
    }
</script>
</html>