<h1> Are you sure you want to</h1>
<form method="POST" action="/products/<?= $product['id'] ?>/destroy">
    <p>Delete this product?</p>
    <button type="submit">Yes</button>
    <button type="button"><a href="/products/<?= $product['id'] ?>/show">No</a></button>
</form>
</body>

</html>