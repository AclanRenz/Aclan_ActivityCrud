<?php 
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO products (productName, description, price, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $productName, $description, $price, $quantity);

    if($stmt->execute()){
        header("Location: index.php");
    }else{
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <form method="POST">
        <h2>Add Product</h2>
        <label>Product Name: </label><input type="text" name="productName" required><br>
        <label>Description: </label><textarea name="description" rows="3"></textarea><br>
        <label>Price: </label><input type="number" name="price" required><br>
        <label>Quantity: </label><input type="number" name="quantity" required><br>
        <button type="submit">ENTER</button>
    </form>
</body>
</html>