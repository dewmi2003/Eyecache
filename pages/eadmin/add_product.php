<?php 
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

require '../../includes/db_connect.php'; 

// --- Fetch categories dynamically ---
$categories = [];
try {
    $catStmt = $pdo->query("SELECT id, category_name FROM categories ORDER BY category_name ASC");
    $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
}

// --- Handle form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['product-description'] ?? '');
    $category_name = trim($_POST['category'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $colors = trim($_POST['colors'] ?? '');
    $sizes = trim($_POST['sizes'] ?? '');
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $status = $_POST['status'] ?? 'Draft';
    
    // --- Handle image upload ---
    $imagePath = null;
    if (!empty($_FILES['file-upload']['name'][0])) {
        $uploadDir = 'assets/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

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
        // 🔹 Fetch category_id from categories table
        $catStmt = $pdo->prepare("SELECT id FROM categories WHERE category_name = ? LIMIT 1");
        $catStmt->execute([$category_name]);
        $category = $catStmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            throw new Exception("Invalid category selected.");
        }

        $category_id = $category['id'];

        // 🔹 Insert product with category_id, colors, sizes
        $stmt = $pdo->prepare("INSERT INTO products 
            (name, description, category_id, sku, colors, sizes, price, stock, status, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $category_id, $sku, $colors, $sizes, $price, $stock, $status, $imagePath]);

        header("Location: products.php?success=1");
        exit;
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error adding product: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product - Admin Panel</title>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<script>
tailwind.config = {
  darkMode: 'class',
  safelist: [
    'dark:bg-gray-900',
    'dark:text-white',
    'dark:border-gray-700',
    'dark:hover:bg-gray-700'
  ]
};
</script>

<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

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

<!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors">
  <div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Add New Product</h2>
    </div>

    <!-- Add Product Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 transition-colors">
      <form class="space-y-6" method="POST" action="add_product.php" enctype="multipart/form-data">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name</label>
          <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
          <textarea name="product-description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
            <select name="category" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
              <option value="">-- Select Category --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['category_name']) ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SKU</label>
            <input type="text" name="sku" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colors (comma-separated)</label>
            <input type="text" name="color" placeholder="e.g. Red, Blue, Black" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sizes (comma-separated)</label>
            <input type="text" name="sizes" placeholder="e.g. S, M, L, XL" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
            <input type="number" step="0.01" name="price" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Quantity</label>
            <input type="number" name="stock" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
          <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-[var(--primary-color)] focus:ring-[var(--primary-color)] sm:text-sm">
            <option>In Stock</option>
            <option>Out of Stock</option>
            <option>Low Stock</option>
            <option>Draft</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Image</label>
          <div class="mt-1 flex flex-col items-center rounded-md border-2 border-dashed border-gray-300 dark:border-gray-600 px-6 pt-5 pb-6">
            <span class="material-symbols-outlined text-4xl text-gray-400">image</span>
            <label class="relative cursor-pointer mt-2 rounded-md bg-white dark:bg-gray-800 font-medium text-[var(--primary-color)] hover:text-[var(--primary-hover-color)]">
              <span>Upload Image</span>
              <input id="file-upload" name="file-upload[]" type="file" accept="image/*" class="sr-only" onchange="previewImage(event)">
            </label>
            <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 10MB</p>
            <div id="image-preview" class="mt-4 flex gap-2 flex-wrap"></div>
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
            reader.onload = e => {
              const img = document.createElement('img');
              img.src = e.target.result;
              img.classList.add('w-20','h-20','object-cover','rounded-md','border');
              previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
          });
        }
        </script>

        <div class="flex justify-end gap-4 pt-6">
          <button type="button" onclick="window.location.href='products.php'"
            class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
            <span class="material-symbols-outlined">cancel</span>Cancel
          </button>
          <button type="submit"
            class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
            <span class="material-symbols-outlined">save</span>Save Product
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
</div>

<!-- 🌗 Dark Mode Script -->
<script>
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

  if (btn) {
    btn.addEventListener('click', () => {
      const isDarkMode = html.classList.toggle('dark');
      localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
      updateUI(isDarkMode);
    });
  }

  function updateUI(isDark) {
    if (icon) icon.textContent = isDark ? '🌙' : '🌞';
    if (text) text.textContent = isDark ? 'Dark Mode' : 'Light Mode';
  }
});
</script>

</body>
</html>
