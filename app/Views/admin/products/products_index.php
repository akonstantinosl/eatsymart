<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Stock</th>
                    <th>Selling Price</th>
                    <th>Box Stock</th>
                    <th>Unit per Box</th>
                    <th>Box Selling Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $index => $product): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($product['product_name']) ?></td>
                        <td><?= esc($product['product_category_name']) ?></td>
                        <td><?= esc($product['supplier_name']) ?></td>
                        <td><?= esc($product['product_stock']) ?></td>
                        <td><?= number_format($product['selling_price'], 0, ',', '.') . " IDR" ?></td> <!-- Selling Price -->
                        <td><?= esc($product['box_bought']) ?></td>
                        <td><?= esc($product['unit_per_box']) ?></td>
                        <td><?= number_format($product['box_selling_price'], 0, ',', '.') . " IDR" ?></td> <!-- Box Selling Price -->
                        <td>
                            <a href="/admin/products/edit/<?= esc($product['product_id']) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
