<?php
session_start();
require 'db_connect.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_GET['id'])) {
    die("Category ID missing.");
}
$category_id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die("Category not found.");
}


$parents = $pdo->query("SELECT id, category_name FROM categories WHERE parent_id IS NULL")->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['category_name'];
    $slug = $_POST['category_slug'];
    $parent_id = $_POST['parent_category'] === "None" ? null : $_POST['parent_category'];
    $status = $_POST['status'];
    $description = $_POST['category_description'];

    $image_path = $category['image_path'];
    if (!empty($_FILES['category_image']['name'])) {
        $target_dir = "uploads/";
        $image_path = $target_dir . basename($_FILES["category_image"]["name"]);
        move_uploaded_file($_FILES["category_image"]["tmp_name"], $image_path);
    }

    $update = $pdo->prepare("UPDATE categories 
                             SET category_name=?, slug=?, parent_id=?, status=?, description=?, image_path=? 
                             WHERE id=?");
    $update->execute([$name, $slug, $parent_id, $status, $description, $image_path, $category_id]);

    header("Location: products.php?msg=Category updated successfully");
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
<title>Admin Panel - Edit Category</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style type="text/tailwindcss">
    :root {
      --primary-color: #1173d4;
      --primary-hover-color: #0e5aab;
    }
</style>
<script>
function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function() {
    const output = document.getElementById('preview');
    output.src = reader.result;
    output.classList.remove("hidden");
  }
  reader.readAsDataURL(event.target.files[0]);
}
</script>
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
<p class="font-semibold"><?= $_SESSION['admin_full_name'] ?></p>
<p class="text-sm text-gray-500"><?= $_SESSION['admin_role'] ?></p>
</div>
</div>
<a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 transition-colors mt-2" href="logout.php">
<span class="material-symbols-outlined">logout</span>
<span>Logout</span>
</a>
</div>
</div>
</aside>

<main class="flex-1 p-8 overflow-y-auto">
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Edit Category</h2>
</div>
<div class="bg-white p-8 rounded-lg shadow-md">
<form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div class="md:col-span-2">
<label class="block text-sm font-medium text-gray-700 mb-2" for="category-name">Category Name</label>
<input type="text" name="category_name" value="<?= htmlspecialchars($category['category_name']); ?>" id="category-name" placeholder="e.g., Electronics" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"/>
</div>

<div class="md:col-span-2">
<label class="block text-sm font-medium text-gray-700 mb-2" for="category-slug">Slug</label>
<input type="text" name="category_slug" value="<?= htmlspecialchars($category['slug']); ?>" id="category-slug" placeholder="e.g., electronics" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"/>
<p class="mt-2 text-sm text-gray-500">The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2" for="parent-category">Parent Category</label>
<select name="parent_category" id="parent-category" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
<option>None</option>
<?php foreach ($parents as $p): ?>
<option value="<?= $p['id']; ?>" <?= ($category['parent_id']==$p['id']) ? 'selected' : '' ?>><?= htmlspecialchars($p['category_name']); ?></option>
<?php endforeach; ?>
</select>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 mb-2" for="status">Status</label>
<select name="status" id="status" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
<option value="Active" <?= ($category['status']=="Active") ? "selected" : "" ?>>Active</option>
<option value="Inactive" <?= ($category['status']=="Inactive") ? "selected" : "" ?>>Inactive</option>
</select>
</div>

<div class="md:col-span-2">
<label class="block text-sm font-medium text-gray-700 mb-2" for="category-description">Description</label>
<textarea name="category_description" id="category-description" rows="4" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"><?= htmlspecialchars($category['description']); ?></textarea>
</div>

<div class="md:col-span-2">
<label class="block text-sm font-medium text-gray-700 mb-2">Category Image</label>
<div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
<div class="space-y-1 text-center">
<span class="material-symbols-outlined text-gray-400 text-5xl">cloud_upload</span>
<div class="flex text-sm text-gray-600">
<label class="relative cursor-pointer bg-white rounded-md font-medium text-[var(--primary-color)] hover:text-[var(--primary-hover-color)]" for="file-upload">
<span>Upload a file</span>
<input id="file-upload" name="category_image" type="file" class="sr-only" onchange="previewImage(event)"/>
</label>
<p class="pl-1">or drag and drop</p>
</div>
<p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
</div>
</div>
<?php if (!empty($category['image_path'])): ?>
<img id="preview" src="<?= htmlspecialchars($category['image_path']); ?>" alt="Preview" class="mt-3 w-24 h-24 object-cover rounded-md"/>
<?php else: ?>
<img id="preview" class="hidden mt-3 w-24 h-24 object-cover rounded-md"/>
<?php endif; ?>
</div>

<div class="md:col-span-2 mt-8 flex justify-end gap-4">
<a href="products.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center gap-2">Cancel</a>
<button type="submit" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
<span class="material-symbols-outlined">add</span> Update Category
</button>
</div>

</form>
</div>
</main>
</div>
</body>
</html>
