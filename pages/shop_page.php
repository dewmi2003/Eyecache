<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';
session_start();

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch all products with category names
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'In Stock' 
        ORDER BY p.id ASC";
$result = $conn->query($sql);

$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sizes = !empty($row['sizes']) ? explode(',', $row['sizes']) : [];

        $colors = [];
        if (!empty($row['colors'])) {
            $colorPairs = explode(',', $row['colors']);
            foreach ($colorPairs as $pair) {
                if (strpos($pair, ':') !== false) {
                    [$name, $hex] = explode(':', $pair);
                    $colors[trim($name)] = trim($hex);
                }
            }
        }

        $products[] = [
            "id"       => $row['id'],
            "name"     => $row['name'],
            "category" => $row['category_name'], // Using category_name from JOIN
            "Code"     => $row['sku'],
            "price"    => floatval($row['price']),
            "currency" => "Rs.",
            "sizes"    => $sizes,
            "colors"   => $colors,
            "image"    => $row['image']
        ];
    }
} else {
    echo "<p style='text-align:center; margin-top:50px;'>No products found.</p>";
    exit;
}

$current_datetime = date('Y-m-d H:i:s');
$current_user = $_SESSION['student'] ?? 'bsstcooray';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Your existing head content -->
<style>
    /* Add these styles to your existing CSS */
    .datetime-banner {
        background: #1a1a1a;
        color: #bbb;
        padding: 10px 20px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1001;
        font-size: 0.9rem;
        border-bottom: 1px solid #333;
    }
    .datetime-banner p {
        margin: 0;
        text-align: right;
    }
    /* Adjust body padding to account for the banner */
    body {
        padding-top: 120px !important;
    }
    /* Rest of your existing styles */
</style>
    <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    body {
        background-color: #111;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        padding-top: 80px;
        margin: 0;
    }

    a {
        text-decoration: none;
    }

    /* Navbar */
    .navbar.fixed-top {
        background-color: #111 !important;
        padding: 1rem 2rem;
        box-shadow: 0 3px 10px rgba(255, 43, 104, 0.2);
        z-index: 1000;
    }

    .navbar-brand {
        color: #FF2B68 !important;
        font-weight: bold;
        font-size: 2rem;
        transition: transform 0.3s;
    }

    .navbar-brand:hover {
        transform: scale(1.1);
        color: #ff4c80 !important;
    }

    .navbar-nav .nav-link {
        color: #FF2B68 !important;
        font-weight: 600;
        margin-left: 1rem;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color 0.3s, transform 0.3s;
    }

    .navbar-nav .nav-link i {
        font-size: 1rem;
    }

    .navbar-nav .nav-link:hover {
        color: #ff4c80 !important;
        transform: translateY(-2px);
    }

    /* Section titles */
    section h2 {
        color: #FF2B68;
        font-weight: bold;
        text-align: center;
        margin-bottom: 1rem;
        position: relative;
    }

    section h2::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background-color: #FF2B68;
        margin: 0.5rem auto 0;
        border-radius: 3px;
    }

    section p.lead {
        text-align: center;
        color: #bbb;
        margin-bottom: 3rem;
    }

    /* Product cards */
    .card {
        background-color: #1a1a1a;
        color: #fff;
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(255, 43, 104, 0.5);
    }

    .card .text-muted {
        color: #bbb !important;
    }

    .product-img {
        height: 300px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .card:hover .product-img {
        transform: scale(1.1) rotate(2deg);
    }

    .btn-primary {
        background: linear-gradient(135deg, #FF2B68, #ff4c80);
        border: none;
        padding: 0.5rem 1.5rem;
        font-weight: bold;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #ff4c80, #FF2B68);
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255, 43, 104, 0.5);
    }

    .alert {
        font-size: 0.9rem;
        text-align: center;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    footer {
        background-color: #111;
        color: #bbb;
        text-align: center;
        padding: 1.5rem 0;
        font-size: 0.9rem;
        margin-top: auto;
        border-top: 1px solid #222;
    }
</style>
</head>

<body>

<!-- DateTime Banner -->


<!-- Navbar -->
<?php include '../includes/navbar.php'; ?>

<!-- Rest of your HTML content remains the same -->





<body>

<!-- Navbar -->
<?php include '../includes/navbar.php'; ?>

<!-- Product Section -->
<section id="shop" class="container my-5">
    <h2>Shop</h2>
    <p class="lead">Exclusive drops, limited colors, designed for NSBM students and beyond.</p>

    <div class="row gy-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid product-img" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="text-muted"><?= htmlspecialchars($product['category']) ?></p>
                        <p class="fw-bold"><?= htmlspecialchars($product['currency']) ?><?= number_format($product['price'], 2) ?></p>

                        <?php if(!empty($product['sizes'])): ?>
                            <p>Sizes:
                                <?php foreach($product['sizes'] as $size): ?>
                                    <span class="badge bg-secondary me-1"><?= htmlspecialchars($size) ?></span>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>

                        <?php if(!empty($product['colors'])): ?>
                            <p>Colors:
                                <?php foreach($product['colors'] as $colorName => $hex): ?>
                                    <span title="<?= htmlspecialchars($colorName) ?>" style="display:inline-block; width:15px; height:15px; background-color:<?= htmlspecialchars($hex) ?>; border:1px solid #ccc; margin:2px; border-radius:50%;"></span>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>

                        <a href="product_page.php?id=<?= $product['id'] ?>" class="btn btn-primary">Add to Cart</a>
                        <div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Footer -->
<footer>
    &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Add to Cart Script -->
<script>
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', () => {
        const cardBody = button.closest('.card-body');
        const alertBox = cardBody.querySelector('.alert');
        const productName = cardBody.querySelector('.card-title').textContent;
        const productId = button.getAttribute('data-id');

        fetch("add_to_cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "product_id=" + productId
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alertBox.innerHTML = `✅ <strong>${productName}</strong> added to cart!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
            } else {
                alertBox.innerHTML = `❌ ${data.message}`;
            }
            alertBox.classList.remove('d-none');
            alertBox.classList.add('show');

            setTimeout(() => {
                alertBox.classList.remove('show');
                alertBox.classList.add('d-none');
            }, 3000);
        });
    });
});
</script>




</body>
</html>