=<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require '../../includes/db_connect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);
    $category_slug = trim($_POST['category_slug']);
    $parent_category = $_POST['parent_category'];
    $status = $_POST['status'];
    $description = trim($_POST['category_description']);
    
    // Handle image upload
    $image_path = null;
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/categories/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['category_image']['type'], $allowed_types)) {
            $error = "Invalid file type. Please upload a JPG, PNG or GIF image.";
        } else {
            $file_extension = pathinfo($_FILES['category_image']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['category_image']['tmp_name'], $upload_path)) {
                $image_path = '/uploads/categories/' . $file_name;
            }
        }
    }
    
    if (empty($error)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO categories (
                    category_name, 
                    slug, 
                    parent_id, 
                    status, 
                    description, 
                    image_path,
                    created_at,
                    updated_at
                ) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            
            $stmt->execute([
                $category_name,
                $category_slug,
                $parent_category === 'None' ? null : $parent_category,
                $status,
                $description,
                $image_path
            ]);
            
            header("Location: products.php");
            exit;
            
        } catch (PDOException $e) {
            $error = "Error adding category: " . $e->getMessage();
        }
    }
}

// Fetch existing categories for parent dropdown
$parent_categories = $pdo->query("SELECT id, category_name FROM categories WHERE parent_id IS NULL ORDER BY category_name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Panel - Add Category</title>

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
    <h2 class="text-4xl font-bold mb-8 text-gray-800 dark:text-gray-100">Add New Category</h2>

    <?php if ($error): ?>
        <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 p-4 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md transition-colors">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Category Name -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Category Name</label>
            <input name="category_name" type="text" placeholder="e.g., Electronics" required
                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]"/>
          </div>

          <!-- Slug -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Slug</label>
            <input name="category_slug" type="text" placeholder="e.g., electronics" required
                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]"/>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">URL-friendly version of the name.</p>
          </div>

          <!-- Parent Category -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Parent Category</label>
            <select name="parent_category" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
              <option value="None">None</option>
              <?php foreach($parent_categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Status</label>
            <select name="status" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

          <!-- Description -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Description</label>
            <textarea name="category_description" rows="4"
                      class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)]"></textarea>
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
                <div id="preview-container" class="mt-3 hidden">
                  <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Preview:</p>
                  <img id="preview-image" class="mx-auto h-24 rounded-md shadow-md border"/>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Buttons -->
        <div class="mt-8 flex justify-end gap-4">
          <button type="button" onclick="window.location.href='products.php'" 
                  class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 font-bold py-2 px-4 rounded-md">
            Cancel
          </button>
          <button type="submit" 
                  class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2">
            <span class="material-symbols-outlined">add</span>Add Category
          </button>
        </div>

      </form>
    </div>

  </main>
</div>

<script>
function previewImage(e) {
  const file = e.target.files[0];
  const cont = document.getElementById('preview-container');
  const img = document.getElementById('preview-image');
  if(file) {
    const reader = new FileReader();
    reader.onload = ev => {
      img.src = ev.target.result;
      cont.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  } else {
    cont.classList.add('hidden');
  }
}
</script>

</body>
</html>