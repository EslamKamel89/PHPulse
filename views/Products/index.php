<h1>Products</h1>

<ul>
    <?php foreach ($products as $product):  ?>
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p><?= htmlspecialchars($product['description']) ?></p>
    <?php endforeach; ?>
</ul>
</body>

</html>