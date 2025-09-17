<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require 'db_connect.php';

$product_id = $_GET['id'] ?? '';
$product = null;
$categories = $pdo->query("SELECT * FROM categories ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch product details if ID is given
if ($product_id) {
    $stmt = $pdo->prepare("SELECT * FROM products1 WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product-name'] ?? '';
    $description = $_POST['product-description'] ?? '';
    $category = $_POST['category'] ?? '';
    $sku = $_POST['sku'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $status = $_POST['status'] ?? '';
    $image_path = $product['image'] ?? '';

    // Handle file upload if a new file is selected
    if (!empty($_FILES['file-upload']['name'][0])) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['file-upload']['name'][0]);
        $targetFile = $uploadDir . $fileName;
        move_uploaded_file($_FILES['file-upload']['tmp_name'][0], $targetFile);
        $image_path = $targetFile;
    }

    $updateStmt = $pdo->prepare("UPDATE product1s SET product_name=?, description=?, category=?, sku=?, price=?, stock=?, status=?, image=? WHERE id=?");
    $updateStmt->execute([$name, $description, $category, $sku, $price, $stock, $status, $image_path, $product_id]);

    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter:wght@400;500;700;900&amp;family=Noto+Sans:wght@400;500;700;900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Edit Product</title>
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
<!-- Sidebar content -->
<div class="px-6 py-4 flex items-center gap-3 border-b">
<div class="p-2 bg-[var(--primary-color)] rounded-full text-white">
<span class="material-symbols-outlined">store</span>
</div>
<h1 class="text-xl font-bold">Admin Panel</h1>
</div>
<div class="flex-1 flex flex-col justify-between">
<nav class="px-4 py-4 space-y-2">
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="home.php">
<span class="material-symbols-outlined">home</span><span>Home</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md bg-[var(--primary-color)] text-white font-medium" href="products.php">
<span class="material-symbols-outlined">inventory_2</span><span>Products</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="users.php">
<span class="material-symbols-outlined">group</span><span>Users</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors" href="customers.php">
<span class="material-symbols-outlined">people</span><span>Customers</span>
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
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors mt-2" href="logout.php">
<span class="material-symbols-outlined">logout</span><span>Logout</span>
</a>
</div>
</div>
</aside>

<main class="flex-1 p-8 overflow-y-auto">
<div class="max-w-4xl mx-auto">
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Edit Product</h2>
</div>
<div class="bg-white rounded-lg shadow-md p-8">
<form class="space-y-6" method="POST" enctype="multipart/form-data">

<div>
<label class="block text-sm font-medium text-gray-700" for="product-name">Product Name</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" 
id="product-name" name="product-name" placeholder="e.g. Premium Wireless Headphones" type="text" value="<?php echo htmlspecialchars($product['product_name'] ?? ''); ?>"/>
</div>

<div>
<label class="block text-sm font-medium text-gray-700" for="product-description">Description</label>
<textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" 
id="product-description" name="product-description" placeholder="Add a detailed description of the product..." rows="4"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700" for="category">Category</label>
<select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="category" name="category">
<?php foreach($categories as $cat): ?>
<option value="<?php echo $cat['category_name']; ?>" <?php echo ($product['category'] ?? '') == $cat['category_name'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['category_name']); ?></option>
<?php endforeach; ?>
</select>
</div>

<div>
<label class="block text-sm font-medium text-gray-700" for="sku">SKU</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" 
id="sku" name="sku" placeholder="e.g. SKU-12345" type="text" value="<?php echo htmlspecialchars($product['sku'] ?? ''); ?>"/>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700" for="price">Price</label>
<div class="relative mt-1 rounded-md shadow-sm">
<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
<span class="text-gray-500 sm:text-sm">$</span>
</div>
<input class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="price" name="price" placeholder="0.00" type="text" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>"/>
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700" for="stock">Stock Quantity</label>
<input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="stock" name="stock" placeholder="100" type="number" value="<?php echo htmlspecialchars($product['stock'] ?? ''); ?>"/>
</div>

<div>
<label class="block text-sm font-medium text-gray-700" for="status">Status</label>
<select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm" id="status" name="status">
<option <?php echo ($product['status'] ?? '')=="In Stock"?'selected':''; ?>>In Stock</option>
<option <?php echo ($product['status'] ?? '')=="Out of Stock"?'selected':''; ?>>Out of Stock</option>
<option <?php echo ($product['status'] ?? '')=="Low Stock"?'selected':''; ?>>Low Stock</option>
<option <?php echo ($product['status'] ?? '')=="Draft"?'selected':''; ?>>Draft</option>
</select>
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700">Product Images</label>
<div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
<div class="space-y-1 text-center">
<?php if(!empty($product['image'])): ?>
<img src="<?php echo htmlspecialchars($product['image']); ?>" class="w-32 h-32 object-cover rounded border mx-auto mb-2"/>
<?php endif; ?>
<span class="material-symbols-outlined text-4xl text-gray-400">image</span>
<div class="flex text-sm text-gray-600">
<label class="relative cursor-pointer rounded-md bg-white font-medium text-[var(--primary-color)] focus-within:outline-none focus-within:ring-2 focus-within:ring-[var(--primary-color)] focus-within:ring-offset-2 hover:text-[var(--primary-hover-color)]" for="file-upload">
<span>Upload files</span>
<input class="sr-only" id="file-upload" multiple name="file-upload[]" type="file"/>
</label>
<p class="pl-1">or drag and drop</p>
</div>
<p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
</div>
</div>
</div>

<div class="flex justify-end gap-4 pt-6">
<button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center gap-2" onclick="window.location.href='products.php'">
<span class="material-symbols-outlined">cancel</span>Cancel
</button>
<button type="submit" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
<span class="material-symbols-outlined">save</span>Save Product
</button>
</div>

</form>
</div>
</div>
</main>
</div>
</body>
</html>
