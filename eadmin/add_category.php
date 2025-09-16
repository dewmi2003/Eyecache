<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_form.php");
    exit;
}

require 'db_connect.php'; // your PDO or mysqli connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['category_name'];
    $slug = $_POST['category_slug'];
    $parent = $_POST['parent_category'] !== "None" ? $_POST['parent_category'] : NULL;
    $status = $_POST['status'];
    $description = $_POST['category_description'];

    // Handle file upload
    $imagePath = null;
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] === 0) {
        $targetDir = "uploads/categories/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['category_image']['name']);
        $targetFile = $targetDir . $fileName;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['category_image']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            }
        }
    }

    // Insert into DB
    $stmt = $pdo->prepare("INSERT INTO categories 
        (category_name, slug, parent_id, status, description, image_path) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $slug, $parent, $status, $description, $imagePath]);

    header("Location: products.php?success=1");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter:wght@400;500;700;900&amp;family=Noto+Sans:wght@400;500;700;900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Add Category</title>
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
<div class="flex justify-between items-center mb-8">
<h2 class="text-4xl font-bold text-gray-800">Add New Category</h2>
</div>
<div class="bg-white p-8 rounded-lg shadow-md">
<form action="add_category.php" method="POST" enctype="multipart/form-data">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
    <!-- Category Name -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2" for="category-name">
        Category Name
      </label>
      <input 
        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
               focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
        id="category-name" 
        name="category_name" 
        placeholder="e.g., Electronics" 
        type="text" 
        required
      />
    </div>

    <!-- Slug -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2" for="category-slug">
        Slug
      </label>
      <input 
        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
               focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
        id="category-slug" 
        name="category_slug" 
        placeholder="e.g., electronics" 
        type="text" 
        required
      />
      <p class="mt-2 text-sm text-gray-500">
        The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only 
        letters, numbers, and hyphens.
      </p>
    </div>

    <!-- Parent Category -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2" for="parent-category">
        Parent Category
      </label>
      <select 
        class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm 
               focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
        id="parent-category" 
        name="parent_category"
      >
        <option value="None">None</option>
        <option value="1">Footwear</option>
        <option value="2">Accessories</option>
        <option value="3">Electronics</option>
      </select>
    </div>

    <!-- Status -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2" for="status">
        Status
      </label>
      <select 
        class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm 
               focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
        id="status" 
        name="status"
      >
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>
    </div>

    <!-- Description -->
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2" for="category-description">
        Description
      </label>
      <textarea 
        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
               focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
        id="category-description" 
        name="category_description" 
        rows="4"
      ></textarea>
    </div>

    <!-- Category Image -->
 <!-- Category Image -->
<div class="md:col-span-2">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Category Image
  </label>
  <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
    <div class="space-y-1 text-center">
      <span class="material-symbols-outlined text-gray-400 text-5xl">
        cloud_upload
      </span>
      <div class="flex text-sm text-gray-600">
        <label 
          class="relative cursor-pointer bg-white rounded-md font-medium text-[var(--primary-color)] 
                 hover:text-[var(--primary-hover-color)] focus-within:outline-none 
                 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[var(--primary-color)]" 
          for="file-upload"
        >
          <span>Upload a file</span>
          <input 
            class="sr-only" 
            id="file-upload" 
            name="category_image" 
            type="file" 
            accept="image/*"
            onchange="previewImage(event)"
          />
        </label>
        <p class="pl-1">or drag and drop</p>
      </div>
      <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>

      <!-- Preview Image -->
      <div id="preview-container" class="mt-3 hidden">
        <p class="text-sm text-gray-600 mb-2">Preview:</p>
        <img id="preview-image" class="mx-auto h-24 rounded-md shadow-md border" />
      </div>
    </div>
  </div>
</div>

<!-- JavaScript to show preview -->
<script>
  function previewImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewContainer.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    } else {
      previewContainer.classList.add('hidden');
    }
  }
</script>


<!-- End of grid -->
</div>

<!-- Buttons container -->
<div class="mt-8 flex justify-end gap-4 w-full">
  <button 
    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md flex items-center gap-2" 
    type="button" 
    onclick="window.location.href='products.php'"
  >
    Cancel
  </button>
  <button 
    class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2" 
    type="submit"
  >
    <span class="material-symbols-outlined">add</span>
    Add Category
  </button>
</div>


</form>

</div>
</main>
</div>

</body></html>