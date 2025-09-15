<?php
// Product Data (use id=8 for Ocean Dust)
$product = [
    "id" => 8, // for cart usage
    "name" => "Ocean Dust",
    "category" => "Women / Casual Wear",
    "Code" => "10022645",
    "price" => 4700,
    "currency" => "LKR.",
    "sizes" => ["S", "M", "L", "XL", "2XL"],
    "colors" => [
        "Blue" => "#1e90ff",
        "Black" => "#000000",
        "Red" => "#FF0000",
        "Yellow" => "#FFFF00"
    ]
];
?>
<html>
<head>
  <meta charset="UTF-8">
  <title><?php echo $product['name']; ?> - EyeCache</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    .sizes button { padding: 12px 22px; margin: 5px; border: 2px solid #333; background: #fff; cursor: pointer; font-weight: 500; border-radius: 5px; font-size: 15px; transition: 0.3s; }
    .sizes button.active { background: #ff3c78; color: white; }
    .color-option { width: 42px; height: 42px; border-radius: 50%; border: 2px solid #fff; cursor: pointer; display: inline-block; margin: 5px; }
    .color-option.active { border: 3px solid #ff3c78; }
    .add-to-cart { margin-top: 25px; display: flex; gap: 15px; align-items: center; }
    .add-to-cart label { font-size: 16px; font-weight: 500; }
    .add-to-cart input { width: 65px; text-align: center; padding: 7px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px; }
    .add-to-cart button { background: #ff3c78; color: #fff; border: none; padding: 13px 28px; cursor: pointer; font-size: 16px; border-radius: 6px; font-weight: 600; transition: 0.3s; }
    .add-to-cart button:hover { opacity: 0.9; transform: translateY(-2px); }
    footer { background-color: #111; color: #bbb; text-align: center; padding: 1.5rem 0; font-size: 1rem; margin-top: auto; border-top: 1px solid #222; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top">
  <a class="navbar-brand fw-bold" href="#">EyeCache</a>
  <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="fas fa-bars"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a href="index.html" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
      <li class="nav-item"><a href="shop_page.html" class="nav-link"><i class="fas fa-store"></i> Shop</a></li>
      <li class="nav-item"><a href="cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart</a></li>
      <li class="nav-item"><a href="#user" class="nav-link"><i class="fas fa-user"></i> User</a></li>
      <li class="nav-item"><a href="#about" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
      <li class="nav-item"><a href="#contact" class="nav-link"><i class="fas fa-envelope"></i> Contact</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="left">
    <img src="assets/WhatsApp Image 2025-06-18 at 21.45.25_46520ade.jpg" alt="<?php echo $product['name']; ?>">
  </div>
  <div class="right">
    <h1><?php echo $product['name']; ?></h1>
    <p class="Code">Code: <?php echo $product['Code']; ?></p>
    <p id="productPrice" class="price"><?php echo $product['currency'] . " " . number_format($product['price']); ?></p>

    <div class="section category">
      <p>CATEGORY</p>
      <span><?php echo $product['category']; ?></span>
    </div>

    <div class="section sizes">
      <p>SIZE</p>
      <?php foreach ($product['sizes'] as $size): ?>
        <button><?php echo $size; ?></button>
      <?php endforeach; ?>
    </div>

    <div class="section colors">
      <p>COLOR</p>
      <?php foreach ($product['colors'] as $name => $hex): ?>
        <span class="color-option" title="<?php echo $name; ?>" style="background: <?php echo $hex; ?>;"></span>
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
const basePrice = <?php echo $product['price']; ?>;
const currency = "<?php echo $product['currency']; ?>";
const priceElement = document.getElementById("productPrice");
const qtyInput = document.getElementById("qtyInput");

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
  let qty = parseInt(qtyInput.value) || 1;
  let selectedSize = document.querySelector(".sizes button.active");
  let selectedColor = document.querySelector(".color-option.active");
  if(!selectedSize || !selectedColor) { alert("Please select a size and color."); return; }

  let user_id = "nfn99a4i0btdo7kbsd5avllfmp";
  let product_id = <?php echo $product['id']; ?>;

  fetch("add_to_cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `user_id=${user_id}&product_id=${product_id}&size=${selectedSize.innerText}&color=${selectedColor.title}&quantity=${qty}`
  }).then(res => res.text())
    .then(data => data === "success" ? alert("Product added to cart!") : alert("Failed: " + data));
});
</script>

<footer>
  &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
