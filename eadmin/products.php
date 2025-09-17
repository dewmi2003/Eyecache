<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_form.php");
    exit;
}

require_once "db_connect.php";


$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);


$productsStmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['delete_category_id'])) {
    $delete_id = intval($_GET['delete_category_id']);
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: products.php");
    exit;
}


if (isset($_GET['delete_product_id'])) {
    $delete_id = intval($_GET['delete_product_id']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: products.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Products</title>
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
<div class="flex justify-between items-center mb-8">
  <h2 class="text-4xl font-bold text-gray-800">Products</h2>
  <div class="flex gap-4">
    <button onclick="window.location.href='add_category.php'" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center gap-2">
      <span class="material-symbols-outlined">add</span>Create New Category
    </button>
    <button onclick="window.location.href='add_product.php'" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
      <span class="material-symbols-outlined">add</span>Add New Product
    </button>
  </div>
</div>


<div class="mb-8">
<h3 class="text-2xl font-bold text-gray-800 mb-4">Product Categories</h3>
<div class="bg-white rounded-lg shadow-md overflow-hidden">
<table class="w-full text-left">
<thead class="bg-gray-100">
<tr>
<th class="p-4 font-semibold">Category Name</th>
<th class="p-4 font-semibold text-center">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
<?php if(!empty($categories)): ?>
  <?php foreach($categories as $cat): ?>
  <tr>
    <td class="p-4"><?php echo htmlspecialchars($cat['category_name']); ?></td>
    <td class="p-4 text-center">
      <a href="edit_category.php?id=<?php echo $cat['id']; ?>" class="text-blue-500 hover:text-blue-700 mx-1">
        <span class="material-symbols-outlined">edit</span>
      </a>
      <a href="?delete_category_id=<?php echo $cat['id']; ?>" onclick="return confirm('Delete this category?');" class="text-red-500 hover:text-red-700 mx-1">
        <span class="material-symbols-outlined">delete</span>
      </a>
    </td>
  </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr><td colspan="2" class="p-4 text-center text-gray-500">No categories found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>


<div>
<h3 class="text-2xl font-bold text-gray-800 mb-4">All Products</h3>
<div class="bg-white rounded-lg shadow-md overflow-hidden">
<table class="w-full text-left">
<thead class="bg-gray-100">
<tr>
<th class="p-4 font-semibold">Product Name</th>
<th class="p-4 font-semibold">Category</th>
<th class="p-4 font-semibold">Price</th>
<th class="p-4 font-semibold">Stock</th>
<th class="p-4 font-semibold text-center">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
<?php if(!empty($products)): ?>
  <?php foreach($products as $prod): ?>
  <tr>
    <td class="p-4 flex items-center gap-4">
      <img src="<?php echo htmlspecialchars($prod['image']); ?>" class="w-12 h-12 object-cover rounded-md" alt="">
      <div>
        <p class="font-medium"><?php echo htmlspecialchars($prod['product_name']); ?></p>
        <p class="text-sm text-gray-500">#<?php echo htmlspecialchars($prod['sku']); ?></p>
      </div>
    </td>
    <td class="p-4"><?php echo htmlspecialchars($prod['category']); ?></td>
    <td class="p-4">$<?php echo number_format($prod['price'], 2); ?></td>
    <td class="p-4">
      <?php
        $stockClass = "text-green-800 bg-green-100";
        if($prod['status']=="Out of Stock") $stockClass="text-red-800 bg-red-100";
        if($prod['status']=="Low Stock") $stockClass="text-yellow-800 bg-yellow-100";
      ?>
      <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $stockClass; ?>">
        <?php echo htmlspecialchars($prod['status']); ?>
      </span>
    </td>
    <td class="p-4 text-center">
      <a href="edit_product.php?id=<?php echo $prod['id']; ?>" class="text-blue-500 hover:text-blue-700 mx-1">
        <span class="material-symbols-outlined">edit</span>
      </a>
      <a href="?delete_product_id=<?php echo $prod['id']; ?>" onclick="return confirm('Delete this product?');" class="text-red-500 hover:text-red-700 mx-1">
        <span class="material-symbols-outlined">delete</span>
      </a>
    </td>
  </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr><td colspan="5" class="p-4 text-center text-gray-500">No products found.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</main>
</div>
</body>
</html>
