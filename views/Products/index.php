<h1>Products</h1>

<ul>
    <?php foreach ($products as $product):  ?>
        <h2>
            <a href="/products/<?= $product['id'] ?>/show">
                <?= htmlspecialchars($product['name']) ?>
            </a>
        </h2>
        <p><?= htmlspecialchars($product['description']) ?></p>
    <?php endforeach; ?>
</ul>
</body>

</html>