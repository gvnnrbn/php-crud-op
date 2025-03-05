<?php 
    session_start();
    include 'connect.php';
    
    /************ CHECK QUERY ****************/
    if(!isset($_GET['updateid'])){
        // set alert and return to table
        $_SESSION['alertMessage'] = "Error: No id found";
        $_SESSION['alertType'] = "danger";
        header("location: list.php ");
        exit();
    }
    $id = $_GET['updateid'];
        
    /************  GET ONE ****************/
    $sql="SELECT * FROM `product` WHERE id=?";
        
    try{
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt,"i", $id);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        if($result && $row = mysqli_fetch_assoc($result)){
            $name = $row['name'];
            $price = $row['price'];
        }else{
            // get_result failed or no rows fetched:
            // set alert and return to table
            $_SESSION['alertMessage'] = "Error: Product not found";
            $_SESSION['alertType'] = "danger";
            header("location: list.php ");
            exit();
        }
    }catch (mysqli_sql_exception $e) {
        // ex: wrong sql, bad use of stmt, ...
        $_SESSION['alertMessage'] = "Error: " . $e->getMessage();
        $_SESSION['alertType'] = "danger";
    }
    
    /************ UPDATE ****************/
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = trim($_POST['name']);
        $price = floatval($_POST['price']);
        
        $sql = "UPDATE `product` SET name=?, price=? 
                WHERE id=?";

        try{
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sdi", $name, $price, $id);
            mysqli_stmt_execute($stmt);

            // set success alert
            $_SESSION['alertMessage'] = "Product $id updated successfully!";
            $_SESSION['alertType'] = "success";
        }catch (mysqli_sql_exception $e) {
            $_SESSION['alertMessage'] = "Error: " . $e->getMessage();
            $_SESSION['alertType'] = "danger";
        }
        // close stmt, connection and return to table
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        header("location: list.php ");
        exit();
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Market</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <div class="container mt-3">
        <div class="row text-center">
            <div class="col-7">
                <h1>UPDATE PRODUCT</h1>
            </div>
            <div class="col-5">
                <a type="button" class="btn btn-primary" href="listProduct.php">
                    GO TO PRODUCTS
                </a>
            </div>
        </div>
    
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required
                    placeholder="Enter product name" autocomplete="off"
                    value = <?php echo $name; ?> >
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price"
                    required step="0.01" min="0"
                    placeholder="Enter product price" autocomplete="off"
                    value = <?php echo $price; ?>>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">UPDATE</button>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>