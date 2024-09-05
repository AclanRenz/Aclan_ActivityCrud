<?php
include 'connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "Product not found!";
        exit;
    }

    $stmt->close();
} else {
    echo "Invalid or missing product ID!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $updated = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE products SET productName = ?, description = ?, price = ?, quantity = ?, updated = ? WHERE id = ?");
    $stmt->bind_param("ssdiss", $productName, $description, $price, $quantity, $updated, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
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
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="POST">
        <label>Product Name: </label>
        <input type="text" name="productName" value="<?php echo htmlspecialchars($product['productName']); ?>" required><br>

        <label>Description: </label>
        <textarea name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea><br>

        <label>Price: </label>
        <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>

        <label>Quantity: </label>
        <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>