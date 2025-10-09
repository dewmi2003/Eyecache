<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require '../../includes/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

// Get category ID
if (!isset($_GET['id'])) {
    die("Category ID missing.");
}
$category_id = $_GET['id'];

// Fetch category details
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    die("Category not found.");
}

// Fetch parent categories for dropdown
$parents = $pdo->query("SELECT id, category_name FROM categories WHERE parent_id IS NULL")->fetchAll(PDO::FETCH_ASSOC);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['category_name'];
    $slug = $_POST['category_slug'];
    $parent_id = $_POST['parent_category'] === "None" ? null : $_POST['parent_category'];
    $status = $_POST['status'];
    $description = $_POST['category_description'];

    $image_path = $category['image_path'];
    if (!empty($_FILES['category_image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $image_path = $target_dir . time() . "_" . basename($_FILES["category_image"]["name"]);
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
<html lang="en" class="">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Panel - Edit Category</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    safelist: [
      'dark:bg-gray-900','dark:text-white','dark:bg-gray-800','dark:text-gray-200',
      'dark:border-gray-700','dark:hover:bg-gray-700','dark:text-gray-400'
    ]
  };
</script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

<style>
  :root { --primary-color: #FF2B68; --primary-hover-color: #B3124A; }
</style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300 font-sans">

<div class="flex h-screen">

  <!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

  <!-- Main Content -->
  <main class="flex-1 p-8 overflow-y-auto bg-gray-50 dark:bg-gray-900 transition-colors">
    <h2 class="text-4xl font-bold mb-8 text-gray-800 dark:text-gray-100">Edit Category</h2>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md transition-colors">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Category Name -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Category Name</label>
            <input name="category_name" type="text" placeholder="e.g., Electronics" required
                   value="<?= htmlspecialchars($category['category_name']); ?>"
                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]"/>
          </div>

          <!-- Slug -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Slug</label>
            <input name="category_slug" type="text" placeholder="e.g., electronics" required
                   value="<?= htmlspecialchars($category['slug']); ?>"
                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]"/>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">URL-friendly version of the name.</p>
          </div>

          <!-- Parent Category -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Parent Category</label>
            <select name="parent_category" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
              <option value="None">None</option>
              <?php foreach ($parents as $p): ?>
              <option value="<?= $p['id']; ?>" <?= ($category['parent_id']==$p['id'])?'selected':'' ?>><?= htmlspecialchars($p['category_name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Status</label>
            <select name="status" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
              <option value="Active" <?= ($category['status']=='Active')?'selected':'' ?>>Active</option>
              <option value="Inactive" <?= ($category['status']=='Inactive')?'selected':'' ?>>Inactive</option>
            </select>
          </div>

          <!-- Description -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Description</label>
            <textarea name="category_description" rows="4"
                      class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]"><?= htmlspecialchars($category['description']); ?></textarea>
          </div>

          <!-- Image -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Category Image</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
              <div class="space-y-1 text-center">
                <span class="material-symbols-outlined text-gray-400 text-5xl">cloud_upload</span>
                <div class="flex text-sm text-gray-600 dark:text-gray-300 justify-center">
                  <label class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-[var(--primary-color)] hover:text-[var(--primary-hover-color)] focus-within:ring-2 focus-within:ring-[var(--primary-color)]">
                    <span>Upload a file</span>
                    <input type="file" name="category_image" class="sr-only" accept="image/*" onchange="previewImage(event)"/>
                  </label>
                  <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 10MB</p>
                <div id="preview-container" class="mt-3 <?= !empty($category['image_path'])?'':'hidden' ?>">
                  <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Preview:</p>
                  <img id="preview-image" class="mx-auto h-24 rounded-md shadow-md border" src="<?= htmlspecialchars($category['image_path']); ?>"/>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Buttons -->
        <div class="mt-8 flex justify-end gap-4">
          <button type="button" onclick="window.location.href='products.php'" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 font-bold py-2 px-4 rounded-md">Cancel</button>
          <button type="submit" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2"><span class="material-symbols-outlined">add</span>Update Category</button>
        </div>

      </form>
    </div>

  </main>
</div>

<script>
function previewImage(e){
  const file = e.target.files[0];
  const cont = document.getElementById('preview-container');
  const img = document.getElementById('preview-image');
  if(file){
    const reader = new FileReader();
    reader.onload = ev => { img.src = ev.target.result; cont.classList.remove('hidden'); };
    reader.readAsDataURL(file);
  } else cont.classList.add('hidden');
}
// Dark mode toggle
document.addEventListener('DOMContentLoaded', () => {
  const html = document.documentElement;
  const btn = document.getElementById('theme-toggle');
  const icon = document.getElementById('theme-icon');
  const text = document.getElementById('theme-text');

  const stored = localStorage.getItem('theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  let isDark = stored === 'dark' || (!stored && prefersDark);
  html.classList.toggle('dark', isDark);
  if(btn) btn.addEventListener('click', () => {
    isDark = html.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    if(icon) icon.textContent = isDark ? '🌙' : '🌞';
    if(text) text.textContent = isDark ? 'Dark Mode' : 'Light Mode';
  });
});
</script>

</body>
</html>
