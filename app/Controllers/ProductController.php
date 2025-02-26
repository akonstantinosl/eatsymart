<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\SupplierModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $supplierModel;

    public function __construct()
    {
        // Initialize models
        $this->productModel = new ProductModel();
        $this->categoryModel = new ProductCategoryModel();
        $this->supplierModel = new SupplierModel();
    }

    // Read function to display the products
    public function index()
    {
        // Get all active products with related category and supplier
        $products = $this->productModel
                    ->select('products.product_id, products.product_name, products.selling_price, products.product_stock, 
                             products.unit_per_box, products.box_selling_price, products.box_bought, 
                             product_categories.product_category_name, suppliers.supplier_name')
                    ->join('product_categories', 'product_categories.product_category_id = products.product_category_id')
                    ->join('suppliers', 'suppliers.supplier_id = products.supplier_id')
                    ->where('product_status', 'active') // Only get active products
                    ->findAll();

        // Pass products data to the view
        return view('admin/products/products_index', ['products' => $products]);
    }

    // Create function to show the form for adding a new product
    public function create()
    {
        // Get all product categories
        $categories = $this->categoryModel->findAll();

        // Get only active suppliers
        $suppliers = $this->supplierModel->where('supplier_status', 'active')->findAll();

        // Pass categories and suppliers to the view
        return view('admin/products/products_create', [
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    // Store function to save a new product to the database
    public function store()
    {
        // Get the submitted data from the form
        $productName = $this->request->getPost('product_name');
        $productCategoryId = $this->request->getPost('product_category_id');
        $supplierId = $this->request->getPost('supplier_id');

        // Validate if the required fields are not empty
        if (empty($productName)) {
            return redirect()->back()->with('error', 'Product name is required.');
        }

        // Generate product_id
        $lastProduct = $this->productModel->orderBy('product_id', 'DESC')->first();
        $lastNumber = 0;
        if ($lastProduct) {
            preg_match('/PDT(\d+)/', $lastProduct['product_id'], $matches);
            if (isset($matches[1])) {
                $lastNumber = (int)$matches[1];
            }
        }

        $newNumber = $lastNumber + 1;
        $productId = 'PDT' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Prepare data for insertion
        $data = [
            'product_id' => $productId,
            'product_name' => $productName,
            'product_category_id' => $productCategoryId,
            'supplier_id' => $supplierId,
            'created_at' => date('Y-m-d H:i:s'),
            'product_status' => 'active', // Default status as active
            'product_stock' => 0, // Default stock to 0
        ];

        // Insert the new product into the database
        $this->productModel->insert($data);

        // Redirect back to the product list with success message
        return redirect()->to('/admin/products')->with('success', 'Product added successfully.');
    }

    // Edit function to allow name, category, supplier, selling price, and box_selling price update
    public function edit($productId)
    {
        // Get product data by product_id
        $product = $this->productModel->find($productId);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        // Get the list of categories
        $categories = $this->categoryModel->findAll();

        // Get only active suppliers
        $suppliers = $this->supplierModel->where('supplier_status', 'active')->findAll();

        // Pass product data and category/supplier list to the view
        return view('admin/products/products_edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    // Update function to update name, category, supplier, selling price, and box_selling_price with validation
    public function update($productId)
    {
        // Get the submitted data from the form
        $productName = $this->request->getPost('product_name');
        $productCategoryId = $this->request->getPost('product_category_id');
        $supplierId = $this->request->getPost('supplier_id');
        $sellingPrice = $this->request->getPost('selling_price');
        $boxSellingPrice = $this->request->getPost('box_selling_price');

        // Validate if the required fields are not empty and are greater than 0
        if (empty($productName) || empty($sellingPrice) || $sellingPrice <= 0) {
            return redirect()->back()->with('error', 'Product name and selling price must be greater than 0.');
        }

        if ($boxSellingPrice <= 0) {
            return redirect()->back()->with('error', 'Box selling price must be greater than 0.');
        }

        // Prepare data for update
        $data = [
            'product_name' => $productName,
            'product_category_id' => $productCategoryId,
            'supplier_id' => $supplierId,
            'selling_price' => $sellingPrice,
            'box_selling_price' => $boxSellingPrice,
        ];

        // Update the product
        $this->productModel->update($productId, $data);

        // Redirect back to the product list
        return redirect()->to('/admin/products')->with('success', 'Product updated successfully.');
    }

    // Delete function to set the product status as inactive instead of deleting it
    public function delete($productId)
    {
        // Find product by ID
        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        // Set the product status to inactive instead of deleting it
        $data = [
            'product_status' => 'inactive',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->productModel->update($productId, $data);

        session()->setFlashdata('success', 'Product successfully deactivated');
        return redirect()->to('/admin/products');
    }
}
