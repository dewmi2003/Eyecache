<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require '../../includes/db_connect.php';

$product_id = $_GET['id'] ?? '';
$product = null;
$categories = $pdo->query("SELECT * FROM categories ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch product details if ID is given
if ($product_id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['product-description'] ?? '';
    $category = $_POST['category'] ?? '';
    $sku = $_POST['sku'] ?? '';
    $color = $_POST['color'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $status = $_POST['status'] ?? '';
    $image_path = $product['image'] ?? '';

    if (!empty($_FILES['file-upload']['name'][0])) {
        $uploadDir = 'assets/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = time() . '_' . basename($_FILES['file-upload']['name'][0]);
        $targetFile = $uploadDir . $fileName;
        move_uploaded_file($_FILES['file-upload']['tmp_name'][0], $targetFile);
        $image_path = $targetFile;
    }

    $updateStmt = $pdo->prepare("UPDATE products 
        SET name=?, description=?, category=?, sku=?, color=?, price=?, stock=?, status=?, image=? 
        WHERE id=?");
    $updateStmt->execute([$name, $description, $category, $sku, $color, $price, $stock, $status, $image_path, $product_id]);

    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Edit Product</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
tailwind.config = {
  darkMode: 'class',
  safelist: [
    'dark:bg-gray-900',
    'dark:bg-gray-800',
    'dark:text-white',
    'dark:text-gray-200',
    'dark:border-gray-700',
    'dark:hover:bg-gray-700'
  ]
};
</script>
<style>
:root {
  --primary-color: #FF2B68;
  --primary-hover-color: #B3124A;
}
</style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 font-sans">
<div class="flex h-screen">

<!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

<main class="flex-1 p-8 overflow-y-auto transition-colors">

<div class="max-w-4xl mx-auto">

<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Edit Product</h2>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 transition-colors">
<form class="space-y-6" method="POST" enctype="multipart/form-data">

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Product Name</label>
<input name="name" type="text" value="<?= htmlspecialchars($product['name'] ?? '') ?>" placeholder="e.g. Premium Wireless Headphones"
class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
<textarea name="product-description" rows="4"
class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Category</label>
<select name="category" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
<option value="">-- Select Category --</option>
<?php foreach($categories as $cat): ?>
<option value="<?= $cat['category_name'] ?>" <?= ($product['category'] ?? '')==$cat['category_name']?'selected':'' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
<?php endforeach; ?>
</select>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">SKU</label>
<input name="sku" type="text" value="<?= htmlspecialchars($product['sku'] ?? '') ?>" placeholder="e.g. SKU-12345"
class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Color</label>
<input name="color" type="text" value="<?= htmlspecialchars($product['color'] ?? '') ?>" placeholder="e.g. Red, Blue, Black"
class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Price</label>
<div class="relative mt-1 rounded-md shadow-sm">
<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
<span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
</div>
<input name="price" type="text" value="<?= htmlspecialchars($product['price'] ?? '') ?>"
class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 pl-7 pr-12 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Stock Quantity</label>
<input name="stock" type="number" value="<?= htmlspecialchars($product['stock'] ?? '') ?>"
class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
<select name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
<option <?= ($product['status'] ?? '')=="In Stock"?'selected':'' ?>>In Stock</option>
<option <?= ($product['status'] ?? '')=="Out of Stock"?'selected':'' ?>>Out of Stock</option>
<option <?= ($product['status'] ?? '')=="Low Stock"?'selected':'' ?>>Low Stock</option>
<option <?= ($product['status'] ?? '')=="Draft"?'selected':'' ?>>Draft</option>
</select>
</div>
</div>

<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Product Image</label>
<div class="mt-1 flex flex-col items-center rounded-md border-2 border-dashed border-gray-300 dark:border-gray-600 px-6 pt-5 pb-6">
<?php if(!empty($product['image'])): ?>
<img src="<?= htmlspecialchars($product['image']) ?>" class="w-32 h-32 object-cover rounded border mx-auto mb-2"/>
<?php endif; ?>
<span class="material-symbols-outlined text-4xl text-gray-400">image</span>
<label class="relative cursor-pointer mt-2 rounded-md bg-white dark:bg-gray-700 font-medium text-[var(--primary-color)] hover:text-[var(--primary-hover-color)]">
<span>Upload Image</span>
<input id="file-upload" name="file-upload[]" type="file" accept="image/*" class="sr-only" onchange="previewImage(event)">
</label>
<p class="text-xs text-gray-500 dark:text-gray-400 mt-2">PNG, JPG, GIF up to 10MB</p>
<div id="image-preview" class="mt-4 flex gap-2 flex-wrap"></div>
</div>
</div>

<div class="flex justify-end gap-4 pt-6">
<button type="button" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-bold py-2 px-4 rounded-md flex items-center gap-2" onclick="window.location.href='products.php'">
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

<script>
// Image preview
function previewImage(event) {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = '';
    const files = event.target.files;
    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('w-20','h-20','object-cover','rounded-md','border');
            previewContainer.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

<!-- 🌗 Dark Mode Script -->

document.addEventListener('DOMContentLoaded', () => {
  const html = document.documentElement;
  const btn = document.getElementById('theme-toggle');
  const icon = document.getElementById('theme-icon');
  const text = document.getElementById('theme-text');

  const stored = localStorage.getItem('theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isDark = stored === 'dark' || (!stored && prefersDark);
  html.classList.toggle('dark', isDark);
  updateUI(isDark);

  btn.addEventListener('click', () => {
    const isDarkMode = html.classList.toggle('dark');
    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
    updateUI(isDarkMode);
  });

  function updateUI(isDark) {
    icon.textContent = isDark ? '🌙' : '🌞';
    text.textContent = isDark ? 'Dark Mode' : 'Light Mode';
  }
});

</script>

</body>
</html>
