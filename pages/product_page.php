<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';
session_start();

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Modified SQL query with JOIN to get category name
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = $productId 
        LIMIT 1";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $sizes = isset($row['sizes']) ? explode(',', $row['sizes']) : [];

    $colors = [];
    if (!empty($row['colors'])) {
        $colorPairs = explode(',', $row['colors']);
        foreach ($colorPairs as $pair) {
            [$name, $hex] = explode(':', $pair);
            $colors[trim($name)] = trim($hex);
        }
    }

    $product = [
        "id"       => $row['id'],
        "name"     => $row['name'],
        "category" => $row['category_name'],
        "Code"     => $row['sku'],
        "price"    => floatval($row['price']),
        "currency" => "Rs.",
        "sizes"    => $sizes,
        "colors"   => $colors,
        "image"    => $row['image']
    ];
} else {
    echo "Product not found.";
    exit;
}

$current_datetime = date('Y-m-d H:i:s');
$current_user = $_SESSION['student'] ?? 'bsstcooray';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['name']) ?> - EyeCache</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="/assets/css/lm.css" rel="stylesheet"/>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Poppins', sans-serif; background: #111; color: #eee; line-height: 1.6; scroll-behavior: smooth; }
a { color: #ff3c78; text-decoration: none; }
img { max-width: 100%; display: block; transition: transform 0.4s ease, box-shadow 0.4s ease; }
.container { width: 90%; max-width: 1200px; margin: 100px auto 40px auto; display: flex; flex-wrap: wrap; gap: 40px; padding: 20px; }
.navbar { background-color: #111 !important; padding: 1rem 2rem; box-shadow: 0 3px 10px rgba(255, 43, 104, 0.2); }
.navbar-brand { color: #FF2B68 !important; font-weight: bold; font-size: 2rem; }
.navbar-nav .nav-link { color: #FF2B68 !important; font-weight: 600; margin-left: 1rem; font-size: 1.1rem; display: flex; align-items: center; gap: 6px; }
.navbar-nav .nav-link:hover { color: #ff4c80 !important; }
.left { flex: 1; min-width: 320px; }
.left img { width: 100%; border-radius: 8px; border: 1px solid #ddd; }
.left img:hover { transform: scale(1.05); box-shadow: 0 8px 25px rgba(255, 60, 120, 0.4); }
.right { flex: 1; min-width: 320px; padding-top: 10px; }
.right p { margin: 6px 0; font-size: 17px; }  
.right h1 { font-size: 32px; margin: 10px 0; } 
.Code { font-size: 18px; font-weight: 500; color: #bbb; }
.price { font-size: 28px; font-weight: bold; margin: 20px 0; color:#ff3c78; }
.section { margin: 25px 0; }
.section p { font-weight: bold; margin-bottom: 8px; color:#ff3c78; font-size: 18px; }
.sizes button { padding: 12px 22px; margin: 5px; border: 2px solid #333; background: #222; color: #fff; cursor: pointer; font-weight: 500; border-radius: 5px; font-size: 15px; transition: 0.3s; }
.sizes button:hover { background: #333; }
.sizes button.active { background: #ff3c78; color: white; border-color: #ff3c78; }
.color-option { width: 42px; height: 42px; border-radius: 50%; border: 2px solid #333; cursor: pointer; display: inline-block; margin: 5px; }
.color-option:hover { transform: scale(1.1); }
.color-option.active { border: 3px solid #ff3c78; box-shadow: 0 0 10px rgba(255, 60, 120, 0.4); }
.add-to-cart { margin-top: 25px; display: flex; gap: 15px; align-items: center; }
.add-to-cart label { font-size: 16px; font-weight: 500; color: #fff; }
.add-to-cart input { width: 65px; text-align: center; padding: 7px; border: 1px solid #333; background: #222; color: #fff; border-radius: 5px; font-size: 15px; }
.add-to-cart button { background: #ff3c78; color: #fff; border: none; padding: 13px 28px; cursor: pointer; font-size: 16px; border-radius: 6px; font-weight: 600; transition: 0.3s; }
.add-to-cart button:hover { opacity: 0.9; transform: translateY(-2px); }
footer { background-color: #111; color: #bbb; text-align: center; padding: 1.5rem 0; font-size: 1rem; margin-top: auto; border-top: 1px solid #222; }
.datetime-banner { background: #222; padding: 10px 20px; color: #999; font-size: 0.9em; border-bottom: 1px solid #333; }
.datetime-banner p { margin: 2px 0; text-align: right; }
</style>
</head>
<body>

<div class="datetime-banner">
    <p>Current Date and Time (UTC - YYYY-MM-DD HH:MM:SS formatted): <?= $current_datetime ?></p>
    <p>Current User's Login: <?= htmlspecialchars($current_user) ?></p>
</div>

<?php include '../includes/navbar.php'; ?>

<div class="container">
    <div class="left">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div class="right">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <p class="Code">Code: <?= htmlspecialchars($product['Code']) ?></p>
        <p id="productPrice" class="price"><?= $product['currency'] . " " . number_format($product['price']); ?></p>

        <div class="section category">
            <p>CATEGORY</p>
            <span><?= htmlspecialchars($product['category']) ?></span>
        </div>

        <div class="section sizes">
            <p>SIZE</p>
            <?php foreach ($product['sizes'] as $size): ?>
                <button><?= htmlspecialchars($size) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="section colors">
            <p>COLOR</p>
            <?php foreach ($product['colors'] as $name => $hex): ?>
                <span class="color-option" title="<?= htmlspecialchars($name) ?>" style="background: <?= htmlspecialchars($hex) ?>;"></span>
            <?php endforeach; ?>
        </div>

        <div class="add-to-cart">
            <label>Qty</label>
            <input id="qtyInput" type="number" value="1" min="1">
            <button id="addToCartBtn">ADD TO CART</button>
        </div>
    </div>
</div>

<script>
const qtyInput = document.getElementById("qtyInput");
const priceElement = document.getElementById("productPrice");
const basePrice = <?= $product['price']; ?>;
const currency = "<?= $product['currency']; ?>";

qtyInput.addEventListener("input", () => {
    let qty = parseInt(qtyInput.value) || 1;
    priceElement.innerText = currency + " " + (basePrice * qty).toLocaleString();
});

const sizeButtons = document.querySelectorAll(".sizes button");
sizeButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        sizeButtons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
    });
});

const colorOptions = document.querySelectorAll(".color-option");
colorOptions.forEach(c => {
    c.addEventListener("click", () => {
        colorOptions.forEach(b => b.classList.remove("active"));
        c.classList.add("active");
    });
});

document.getElementById("addToCartBtn").addEventListener("click", () => {
    const selectedSize = document.querySelector(".sizes button.active");
    const selectedColor = document.querySelector(".color-option.active");

    if (!selectedSize || !selectedColor) {
        alert("Please select a size and color.");
        return;
    }

    const qty = parseInt(qtyInput.value) || 1;
    const size = selectedSize.innerText;
    const color = selectedColor.getAttribute("title");
    const product_id = <?= $product['id']; ?>;
    const user_id = <?= isset($_SESSION['student']) ? $_SESSION['student'] : 'null' ?>;

    fetch("add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `user_id=${user_id}&product_id=${product_id}&size=${encodeURIComponent(size)}&color=${encodeURIComponent(color)}&quantity=${qty}`
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("Product added to cart!");
        } else {
            alert("Failed: " + data);
        }
    })
    .catch(err => alert("Error: " + err));
});
</script>

<footer>
    &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>