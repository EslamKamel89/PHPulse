<h1>Products </h1>
<p>Total: <?= $total ?></p>
<a href="/products/new">+ Product</a>
<ul>
    <?php foreach ($products as $product):  ?>
        <h2>
            <a href="/products/<?= $product['id'] ?>/show">
                <?= htmlspecialchars($product['name']) ?>
            </a>
        </h2>
        <p><?= htmlspecialchars($product['description'] ?? '') ?></p>
    <?php endforeach; ?>
</ul>
</body>

</html>