<?php
    session_start();
    
    include 'connect.php';
    
    $alertMessage = "";
    $alertType = "";

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        $sql="DELETE FROM `product` WHERE id=?";
        
        try{
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt,"i", $id);
            mysqli_stmt_execute($stmt);

            $_SESSION['alertMessage'] = "Product deleted successfully!";
            $_SESSION['alertType'] = "success";
        }catch (mysqli_sql_exception $e) {
            $_SESSION['alertMessage'] = "Error: " . $e->getMessage();
            $_SESSION['alertType'] = "danger";
        }
        mysqli_close($con);

        header("location: listProduct.php ");
        exit();
    }
?>