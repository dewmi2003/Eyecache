<?php 
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include "../../includes/db_connect.php";

// Fetch categories
$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch products
$productsStmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle category deletion
if (isset($_GET['delete_category_id'])) {
    $delete_id = intval($_GET['delete_category_id']);
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: products.php");
    exit;
}

// Handle product deletion
if (isset($_GET['delete_product_id'])) {
    $delete_id = intval($_GET['delete_product_id']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$delete_id]);
    header("Location: products.php");
    exit;
}

// Get current UTC time
$current_time = gmdate('Y-m-d H:i:s');
$current_user = $_SESSION['admin'] ?? 'bsstcooray'; // Default to bsstcooray if not set
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<title>Admin Panel - Products</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
tailwind.config = {
  darkMode: 'class',
  safelist: [
    'dark:bg-gray-900','dark:text-white','dark:bg-gray-800','dark:text-gray-200','dark:border-gray-700','dark:hover:bg-gray-700',
    'dark:text-gray-400','dark:text-yellow-300'
  ]
};
</script>

<style>
:root {
  --primary-color: #FF2B68;
  --primary-hover-color: #B3124A;
}
.badge {
  @apply px-2 py-1 rounded-full text-xs font-semibold;
}
.badge-green { @apply text-green-800 bg-green-100 dark:text-green-300 dark:bg-green-800; }
.badge-yellow { @apply text-yellow-800 bg-yellow-100 dark:text-yellow-300 dark:bg-yellow-800; }
.badge-red { @apply text-red-800 bg-red-100 dark:text-red-300 dark:bg-red-800; }
.color-circle {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  display: inline-block;
  margin-right: 5px;
  border: 2px solid #fff;
}
</style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-white transition-colors duration-300 font-sans">

<div class="flex h-screen">

<!-- Sidebar -->
<?php include 'admin_nav.php'; ?>

<!-- Main -->
<main class="flex-1 p-6 lg:p-8 overflow-auto">

  <!-- Header with Date/Time and User -->
  <div class="mb-6">
    <div class="text-sm text-gray-600 dark:text-gray-400">
      <p>Current Date and Time (UTC): <?php echo $current_time; ?></p>
      <p>Current User's Login: <?php echo htmlspecialchars($current_user); ?></p>
    </div>
  </div>

  <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
    <h2 class="text-4xl font-bold">Products</h2>
    <div class="flex gap-4 flex-wrap">
      <button onclick="window.location.href='add_category.php'" class="bg-gray-200 hover:bg-gray-300 text-gray-800 dark:text-gray-900 font-bold py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined">add</span>Create Category
      </button>
      <button onclick="window.location.href='add_product.php'" class="bg-[var(--primary-color)] hover:bg-[var(--primary-hover-color)] text-white font-bold py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
        <span class="material-symbols-outlined">add</span>Add Product
      </button>
    </div>
  </div>

  <!-- Categories Table -->
  <div class="mb-8 overflow-x-auto">
    <h3 class="text-2xl font-bold mb-4">Product Categories</h3>
    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <th class="p-4 font-semibold">ID</th>
          <th class="p-4 font-semibold">Category Name</th>
          <th class="p-4 font-semibold text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php if(!empty($categories)): ?>
          <?php foreach($categories as $cat): ?>
            <tr>
              <td class="p-4"><?php echo htmlspecialchars($cat['id']); ?></td>
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
          <tr><td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">No categories found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Products Table -->
  <div class="overflow-x-auto">
    <h3 class="text-2xl font-bold mb-4">All Products</h3>
    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
      <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
          <?php
            if(!empty($products)){
              $columns = array_keys($products[0]);
              foreach($columns as $col){
                echo "<th class='p-4 font-semibold'>".htmlspecialchars(ucwords(str_replace('_',' ',$col)))."</th>";
              }
              echo "<th class='p-4 font-semibold text-center'>Actions</th>";
            }
          ?>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        <?php if(!empty($products)): ?>
          <?php foreach($products as $prod): ?>
            <tr>
              <?php foreach($columns as $col): ?>
                <td class="p-4">
                  <?php 
                  switch($col){
                    case 'image':
                      echo '<img src="'.htmlspecialchars($prod[$col]).'" class="w-12 h-12 object-cover rounded-md" alt="">';
                      break;
                    case 'colors':
                      if(!empty($prod[$col])){
                        $colorsArr = explode(',', $prod[$col]);
                        foreach($colorsArr as $c){
                          $cHex = '#000';
                          if(strpos($c,':')!==false) list(,$cHex)=explode(':',$c);
                          echo '<span class="color-circle" style="background:'.$cHex.';"></span>';
                        }
                      }
                      break;
                    case 'sizes':
                      echo htmlspecialchars($prod[$col]);
                      break;
                    case 'status':
                      $cls = "badge-green";
                      if($prod[$col]=="Out of Stock") $cls="badge-red";
                      if($prod[$col]=="Low Stock") $cls="badge-yellow";
                      echo '<span class="badge '.$cls.'">'.htmlspecialchars($prod[$col]).'</span>';
                      break;
                    default:
                      echo htmlspecialchars($prod[$col]);
                  }
                  ?>
                </td>
              <?php endforeach; ?>
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
          <tr><td colspan="<?php echo count($columns)+1; ?>" class="p-4 text-center text-gray-500 dark:text-gray-400">No products found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</main>
</div>

</body>
</html>