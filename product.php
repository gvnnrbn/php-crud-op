<?php 
    session_start();
    include 'connect.php';
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = trim($_POST['name']);
        $price = floatval($_POST['price']);
        
        $sql = "INSERT INTO `product` (name, price) VALUES (?, ?)";
        
        try{
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sd", $name, $price);
            mysqli_stmt_execute($stmt);

            $_SESSION['alertMessage'] = "Product created successfully!";
            $_SESSION['alertType'] = "success";
        }catch (mysqli_sql_exception $e) {
            $_SESSION['alertMessage'] = "Error: " . $e->getMessage();
            $_SESSION['alertType'] = "danger";
        }
        mysqli_close($con);
        //header("Location: " . $_SERVER['PHP_SELF']);
        header("location: listProduct.php");
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
                <h1>CREATE PRODUCT</h1>
            </div>
            <div class="col-5">
                <a type="button" class="btn btn-primary" href="listProduct.php">
                    GO TO PRODUCTS
                </a>
            </div>
        </div>
    
        <!-- <?php if (!empty($alertMessage)): ?>
            <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
                <?= $alertMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?> -->
    
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required
                    placeholder="Enter product name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price"
                    required step="0.01" min="0"
                    placeholder="Enter product price" autocomplete="off">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">CREATE</button>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>