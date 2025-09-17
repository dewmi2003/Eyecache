<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EyeCache - Luxury University Streetwear</title>

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
            padding-top: 80px; /* navbar height */
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

        /* Footer */
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand fw-bold" href="#">EyeCache</a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="fas fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="/ehome/Eyecache1.html" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a href="/eshop/shop_page.php" class="nav-link"><i class="fas fa-store"></i> Shop</a></li>
        <li class="nav-item"><a href="/ecart/cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        <li class="nav-item"><a href="/elogin/re/EyecacheLogin.php" class="nav-link"><i class="fas fa-user"></i> User</a></li>
        <li class="nav-item"><a href="/eaboutus/index.html" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
        <li class="nav-item"><a href="/econtact/index.html" class="nav-link"><i class="fas fa-envelope"></i> Contact</a></li>
      </ul>
    </div>
    </nav>

    <!-- Product Section -->
    <section id="shop" class="container my-5">
        <h2>Shop</h2>
        <p class="lead">Exclusive drops, limited colors, designed for NSBM students and beyond.</p>

        <div class="row gy-4">

                <!-- Product 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="assets/Black - Moon - Dad Cap.jpeg" class="img-fluid product-img" alt="SolarFlare Tee">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">SolarFlare Tee</h5>
                        <p class="text-muted">Color: Red</p>
                        <p class="fw-bold">Rs. 3990</p>
                        <button class="btn btn-primary add-to-cart-btn" data-id="1"><a href="/eproduct/Citrine Glow.php" class="nav-link">Add to Cart</a></button>
                        <div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="assets/download (19).jpeg" class="img-fluid product-img" alt="Midnight Mirage Hoodie">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Midnight Mirage Hoodie</h5>
                        <p class="text-muted">Color: Black</p>
                        <p class="fw-bold">Rs. 6990</p>
                        <button class="btn btn-primary add-to-cart-btn" data-id="1"><a href="/eproduct/Midnight Mirage Hoodie.php" class="nav-link">Add to Cart</a></button>                        <div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="assets/download (20).jpeg" class="img-fluid product-img" alt="Eclipse Cap">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Eclipse Cap</h5>
                        <p class="text-muted">Color: White</p>
                        <p class="fw-bold">Rs. 1990</p>
                        <button class="btn btn-primary add-to-cart-btn" data-id="1"><a href="/eproduct/Eclipse Cap.php" class="nav-link">Add to Cart</a></button><div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="assets/Essential Heavyweight Oversized Hoodie - Mid Green _ S.jpeg" class="img-fluid product-img" alt="Solstice Red">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Solstice Red</h5>
                        <p class="text-muted">Color: Deep Crimson</p>
                        <p class="fw-bold">Rs. 4500</p>
                        <button class="btn btn-primary add-to-cart-btn" data-id="1"><a href="/eproduct/Solstice Red.php" class="nav-link">Add to Cart</a></button>                        <div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>

            <!-- Product 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="assets/ivory.jpeg" class="img-fluid product-img" alt="Eclipse Black">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Eclipse Black</h5>
                        <p class="text-muted">Color: Pure Black</p>
                        <p class="fw-bold">Rs. 6990</p>
                        <button class="btn btn-primary add-to-cart-btn" data-id="1"><a href="/eproduct/Eclipse Black.php" class="nav-link">Add to Cart</a></button>                        <div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>

            <!-- Product 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="assets/MARISA OVERSIZED HOODIE - Medium _ Black.jpeg" class="img-fluid product-img" alt="Ivory Bloom">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Ivory Bloom</h5>
                        <p class="text-muted">Color: Soft Cream</p>
                        <p class="fw-bold">Rs. 4200</p>
                        <button class="btn btn-primary add-to-cart-btn" data-id="1"><a href="/eproduct/Ivory Bloom.php" class="nav-link">Add to Cart</a></button>                        <div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>

            <!-- Product 7 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="overflow-hidden">
                        <img src="assets/Shen Fashion_ The Rising Star in Sustainable Luxury » Styling Outfits.jpeg" class="img-fluid product-img" alt="Citrine Glow">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Citrine Glow</h5>
                        <p class="text-muted">Color: Light Yellow</p>
                        <p class="fw-bold">Rs. 4300</p>
                        <button class="btn btn-primary add-to-cart-btn" data-id="1"><a href="/eproduct/Citrine Glow.php" class="nav-link">Add to Cart</a></button>                        <div class="alert alert-success alert-dismissible fade d-none mt-3" role="alert"></div>
                    </div>
                </div>
            </div>
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
