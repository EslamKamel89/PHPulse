  <label for="name">Name</label>
  <input type="text" name="name" id="name" value="<?= $product['name'] ?? '' ?>">
  <?php if (isset($errors['name'])): ?>
      <p style="color:red; font-size: small;">
          <?= $errors['name'] ?>
      </p>
  <?php endif; ?>
  <label for="description">Description</label>
  <textarea name="description" id="description"><?= $product['description'] ?? '' ?></textarea>
  <button type="submit">Save</button>
  <button type="button"><a href="/products/<?= $product['id'] ?? 'not found' ?>/show">Cancel</a></button>