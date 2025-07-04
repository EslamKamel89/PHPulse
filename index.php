<?php
function initPdo(): PDO | null {
    try {
        $host = 'localhost';
        $dbname = 'product_db';
        $username = 'root';
        $password = '';
        $dsn  = "mysql:host=$host;dbname=$dbname;charset=utf8mb4;port=3306";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $error) {
        error_log("Database error: " . $error->getMessage());
        die("Something went wrong.");
    }
}
$pdo = initPdo();
$stmt = $pdo->query('SELECT * FROM product');
$products = $stmt->fetchAll(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Products</h1>

    <ul>
        <?php foreach ($products as $product):  ?>
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p><?= htmlspecialchars($product['description']) ?></p>
        <?php endforeach; ?>
    </ul>
</body>

</html>