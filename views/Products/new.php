<h1>New Product</h1>
<form method="POST" action="/products/create">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <?php if (isset($errors['name'])): ?>
        <p style="color:red; font-size: small;">
            <?= $errors['name'] ?>
        </p>
    <?php endif; ?>
    <label for="description">Description</label>
    <textarea name="description" id="description"></textarea>
    <button type="submit">Save</button>
</form>
</body>

</html>