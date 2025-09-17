<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_form.php");
    exit;
}

require_once "db_connect.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product-name'] ?? '';
    $description = $_POST['product-description'] ?? '';
    $category = $_POST['category'] ?? '';
    $sku = $_POST['sku'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $status = $_POST['status'] ?? 'Draft';
    
    
    $imagePath = null;
    if (!empty($_FILES['file-upload']['name'][0])) {
        $uploadDir = 'uploads/';
        foreach ($_FILES['file-upload']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['file-upload']['name'][$key]);
            $targetFile = $uploadDir . time() . '_' . $fileName;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

           
            $allowed = ['jpg','jpeg','png','gif'];
            if (in_array($fileType, $allowed)) {
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $imagePath = $targetFile; 
                    break; 
                }
            }
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO products (product_name, description, category, sku, price, stock, status, image) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $category, $sku, $price, $stock, $status, $imagePath]);
        header("Location: products.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "Error adding product: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter:wght@400;500;700;900&amp;family=Noto+Sans:wght@400;500;700;900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Add Product</title>
<link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style type="text/tailwindcss">
        :root {
          --primary-color: #1173d4;
          --primary-hover-color: #0e5aab;
        }
    </style>
</head>
<body class="bg-gray-50" style="font-family: Inter, 'Noto Sans', sans-serif;">
<div class="flex h-screen">
<aside class="w-64 bg-white text-gray-800 flex flex-col shadow-lg">
<div class="px-6 py-4 flex items-center gap-3 border-b">
<div class="p-2 bg-[var(--primary-color)] rounded-full text-white">
<span class="material-symbols-outlined">
                    store
                </span>
</div>
<h1 class="text-xl font-bold">Admin Panel</h1>
</div>
<div class="flex-1 flex flex-col justify-between">
<nav class="px-4 py-4 space-y-2">
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="home.php">
<span class="material-symbols-outlined">home</span>
<span>Home</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md bg-[var(--primary-color)] text-white font-medium" href="products.php">
<span class="material-symbols-outlined">inventory_2</span>
<span>Products</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="users.php">
<span class="material-symbols-outlined">group</span>
<span>Users</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="customers.php">
<span class="material-symbols-outlined">people</span>
<span>Customers</span>
</a>
</nav>
<div class="px-4 py-4 border-t">
<div class="flex items-center gap-3 mb-4">
<img alt="User Avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDsnnO_zYh00P_h9W9wfQEPKdkyZC3EQStflmIz19ZTAM8FehcV6CtGWnacI5Dg6JIGqc2H69DrRMt5YdznX0aO_okymxK52o6SMIhmnABRklLKPKXuq1FNYTUfe8YzrtDzBgjoAxHVUp1Z228UYBOSOx-LpgPgQ-oP6a5WOpsY3WlOM4qWXmSybwEr6iuod6qlsOhUv1WQStexmNJRul9qbhIusfe1Dc9h-KMt4M1OcZANfE2cPGciS_3Xubg1-J9JoDgjS5WPUpUq"/>
<div>
<p class="font-semibold"><?php echo $_SESSION['admin_full_name']; ?></p>
<p class="text-sm text-gray-500"><?php echo $_SESSION['admin_role']; ?></p>
</div>
</div>
<!-- <a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="#">
<span class="material-symbols-outlined">settings</span>
<span>Settings</span> -->
</a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors mt-2" href="logout.php">
<span class="material-symbols-outlined">logout</span>
<span>Logout</span>
</a>
</div>
</div>
</aside>
<main class="flex-1 p-8 overflow-y-auto">
<div class="max-w-4xl mx-auto">
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Add New Product</h2>
</div>
<div class="bg-white rounded-lg shadow-md p-8">
<form class="space-y-6" method="POST" action="add_product.php" enctype="multipart/form-data">
<div>
<label class="block text-sm font-medium text-gray-700" for="product-name">Product Name</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="product-name" name="product-name" placeholder="e.g. Premium Wireless Headphones" type="text"/>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="product-description">Description</label>
<textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="product-description" name="product-description" placeholder="Add a detailed description of the product..." rows="4"></textarea>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700" for="category">Category</label>
<select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="category" name="category">
<option>Electronics</option>
<option>Footwear</option>
<option>Accessories</option>
<option>Apparel</option>
</select>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="sku">SKU</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="sku" name="sku" placeholder="e.g. SKU-12345" type="text"/>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700" for="price">Price</label>
<div class="relative mt-1 rounded-md shadow-sm">
<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
<span class="text-gray-500 sm:text-sm">$</span>
</div>
<input class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="price" name="price" placeholder="0.00" type="text"/>
</div>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="stock">Stock Quantity</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="stock" name="stock" placeholder="100" type="number"/>
</div>
<div>
<label class="block text-sm font-medium text-gray-700" for="status">Status</label>
<select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="status" name="status">
<option>In Stock</option>
<option>Out of Stock</option>
<option>Low Stock</option>
<option>Draft</option>
</select>
</div>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Product Images</label>
    <div class="mt-1 flex flex-col items-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
        <div class="space-y-1 text-center">
            <span class="material-symbols-outlined text-4xl text-gray-400">
                image
            </span>
            <div class="flex text-sm text-gray-600 items-center justify-center gap-2">
                <label class="relative cursor-pointer rounded-md bg-white font-medium text-[var(--primary-color)] focus-within:outline-none focus-within:ring-2 focus-within:ring-[var(--primary-color)] focus-within:ring-offset-2 hover:text-[var(--primary-hover-color)]" for="file-upload">
                    <span>Upload files</span>
                    <input class="sr-only" id="file-upload" name="file-upload[]" type="file" accept="image/*" onchange="previewImage(event)">
                </label>
                <p class="pl-1">or drag and drop</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
            
            <div id="image-preview" class="mt-4 flex gap-2 flex-wrap"></div>
        </div>
    </div>
</div>
<script>
function previewImage(event) {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = ''; 

    const files = event.target.files;
    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('w-20', 'h-20', 'object-cover', 'rounded-md', 'border');
            previewContainer.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
}
</script>

<div class="flex justify-end gap-4 pt-6">
<button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center gap-2" onclick="window.location.href='add_product.php'" >
<span class="material-symbols-outlined">cancel</span>
                        Cancel
                    </button>
<button class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
<span class="material-symbols-outlined">save</span>
                        Save Product
                    </button>
</div>
</form>
</div>
</div>
</main>
</div>
</body></html>