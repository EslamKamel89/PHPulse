<h1> <?= $product['name'] ?></h1>
<div> <?= $product['description'] ?></div>
<p><a href="/products/<?= $product['id'] ?>/edit">Edit</a></p>
<p><a href="/products/<?= $product['id'] ?>/delete">Delete</a></p>
</body>

</html>