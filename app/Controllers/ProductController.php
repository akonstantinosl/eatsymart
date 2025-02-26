<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\SupplierModel;

class ProductController extends BaseController
{
    // Read function to display the products
    public function index()
    {
        // Load models
        $productModel = new ProductModel();
        $categoryModel = new ProductCategoryModel();
        $supplierModel = new SupplierModel();

        // Get all products with related category and supplier
        $products = $productModel
                    ->select('products.product_id, products.product_name, products.selling_price, products.product_stock, 
                             products.unit_per_box, products.box_selling_price, products.box_bought, 
                             product_categories.product_category_name, suppliers.supplier_name')
                    ->join('product_categories', 'product_categories.product_category_id = products.product_category_id')
                    ->join('suppliers', 'suppliers.supplier_id = products.supplier_id')
                    ->findAll();

        // Pass products data to the view
        return view('admin/products/products_index', ['products' => $products]);
    }

    // Edit function to allow name, selling price, and box_selling_price update only
    public function edit($productId)
    {
        $productModel = new ProductModel();
        $categoryModel = new ProductCategoryModel();
        $supplierModel = new SupplierModel();

        // Get product data by product_id
        $product = $productModel->find($productId);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        // Get the list of categories and suppliers
        $categories = $categoryModel->findAll();
        $suppliers = $supplierModel->findAll();

        // Pass product data and category/supplier list to the view
        return view('admin/products/products_edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    // Update function to update name, selling price, and box_selling_price with validation
    public function update($productId)
    {
        $productModel = new ProductModel();

        // Get the submitted data from the form
        $productName = $this->request->getPost('product_name');
        $sellingPrice = $this->request->getPost('selling_price');
        $boxSellingPrice = $this->request->getPost('box_selling_price');
        $unitPerBox = $this->request->getPost('unit_per_box');

        // Validate if the required fields are not empty and are greater than 0
        if (empty($productName) || empty($sellingPrice) || $sellingPrice <= 0) {
            return redirect()->back()->with('error', 'Product name and selling price must be greater than 0.');
        }

        if ($boxSellingPrice <= 0) {
            return redirect()->back()->with('error', 'Box selling price must be greater than 0.');
        }

        // Prepare data for update
        $data = [
            'product_name'   => $productName,
            'selling_price'  => $sellingPrice,
            'box_selling_price' => $boxSellingPrice,
        ];

        // Update the product
        $productModel->update($productId, $data);

        // Redirect back to the product list
        return redirect()->to('/admin/products')->with('success', 'Product updated successfully.');
    }
}
