<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Product</h3>
        <div class="card-tools">
            <a href="/admin/products" class="btn btn-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/admin/products/update/<?= $product['product_id'] ?>" method="post">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= old('product_name', $product['product_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="selling_price">Selling Price</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="selling_price" name="selling_price" value="<?= old('selling_price', $product['selling_price']) ?>" required min="1">
                    <div class="input-group-append">
                        <span class="input-group-text">IDR</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="box_selling_price">Box Selling Price</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="box_selling_price" name="box_selling_price" value="<?= old('box_selling_price', $product['box_selling_price']) ?>" required min="1">
                    <div class="input-group-append">
                        <span class="input-group-text">IDR</span>
                    </div>
                </div>
                <small class="text-muted">Box selling price cannot be more than selling price multiplied by unit per box.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/admin/products" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
