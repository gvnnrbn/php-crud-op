<?php 
  session_start();
  include 'connect.php';

  // handle delete/update alerts
  $alertMessage = $_SESSION['alertMessage'] ?? "";
  $alertType = $_SESSION['alertType'] ?? "";

  unset($_SESSION['alertMessage'], $_SESSION['alertType']);
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
    <h1>PRODUCTS</h1>

    <?php if (!empty($alertMessage)): ?>
        <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
            <?= $alertMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container">
      <a type="button" class="btn btn-primary" href="create.php">
        NEW PRODUCT
      </a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">NAME</th>
          <th scope="col">PRICE</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sql = "select * from `product`";
          $result=mysqli_query($con, $sql);
          if($result){
            while($row=mysqli_fetch_assoc($result)){
              $id = $row['id'];
              $name = $row['name'];
              $price = $row['price'];
              echo
                '<tr>
                  <th scope="row">'.$id.'</th>
                  <td>'.$name.'</td>
                  <td>'.$price.'</td>
                  <td>
                    <button class="btn btn-primary">
                      <a href="update.php?updateid='.$id.'" class="text-light" style="text-decoration: none">Update</a>
                    </button>
                    <button class="btn btn-danger">
                      <a href="delete.php?deleteid='.$id.'" class="text-light" style="text-decoration: none">Delete</a>
                    </button>
                  </td>
                </tr>';
            }
          }
        ?>
      </tbody>
    </table>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>