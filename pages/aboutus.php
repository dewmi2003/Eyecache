<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - EyeCache Clothing</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="/assets/css/lm.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(270deg, var(--base-color), var(--base-variant), var(--base-color));
      background-size: 600% 600%;
      animation: gradientBG 12s ease infinite;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
      color: var(--secondary-text);
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .navbar {
      background-color: var(--base-variant) !important;
      padding: 1rem 2rem;
      box-shadow: 0 3px 10px rgba(255, 43, 104, 0.2);
    }
    .navbar-brand {
      color: #FF2B68 !important;
      font-weight: bold;
      font-size: 1.8rem;
    }
    .navbar-nav .nav-link {
      color: #FF2B68 !important;
      font-weight: 600;
      margin-left: 1rem;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.3s ease;
    }
    .navbar-nav .nav-link:hover {
      color: #ff4c80 !important;
    }
    h2, h3 {
      color: #FF2B68;
      font-weight: 700;
    }
    .btn-custom {
      background-color: #FF2B68;
      color: #fff;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 30px;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }
    .btn-custom:hover {
      background-color: #ff4c80;
      color: #fff;
    }
    footer {
      background-color: var(--base-variant);
      color: var(--secondary-text);
      text-align: center;
      padding: 1.5rem 0;
      font-size: 0.9rem;
      margin-top: auto;
      border-top: 1px solid #222;
    }
    .hero {
      text-align: center;
      padding: 120px 20px 60px;
      color: var(--text-color);
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      color: #FF2B68;
    }
    .hero p {
      font-size: 1.2rem;
      margin-top: 10px;
      color: var(--secondary-text);
    }
    .card {
      background: var(--base-variant);
      border: none;
      border-radius: 15px;
      color: var(--secondary-text);
      box-shadow: 0 4px 12px rgba(0,0,0,0.5);
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .team img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 15px;
      border: 3px solid #FF2B68;
    }
    .btn-shop {
      background-color: #FF2B68;
      padding: 12px 30px;
      border-radius: 30px;
      color: #fff;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s;
    }
    .btn-shop:hover {
      background-color: #622d3c;
      color: #fff;
    }
  </style>
                                  <link href="/assets/css/theme.css" rel="stylesheet"/>
</head>
<body>

<?php include '../includes/navbar.php'; ?>

  <div class="hero">
    <h1>About EyeCache Clothing</h1>
    <p>Trendy • Affordable • Stylish - For Every Undergraduate Girl</p>
  </div>

  <div class="container mission text-center mb-5">
    <h2>Our Mission</h2>
    <p>We aim to bring stylish, affordable, and comfortable outfits to every university girl. 
       Our vision is to empower young women to express themselves through fashion while staying on budget.</p>
  </div>

  <div class="container why-us mb-5">
    <h2 class="text-center mb-4">Why Choose Us?</h2>
    <div class="row text-center">
      <div class="col-md-4">
        <div class="card p-4">
          <h4>🎀 Trendy Styles</h4>
          <p>We handpick the latest fashion trends to keep you looking fresh every semester.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4">
          <h4>💸 Affordable Prices</h4>
          <p>Fashion on a student budget! Quality clothes that won’t break your wallet.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-4">
          <h4>🚚 Fast Delivery</h4>
          <p>Get your order delivered quickly so you’re always ready for campus life.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container team text-center mb-5">
    <h2>Meet Our Team</h2>
    <div class="row mt-4">
      <div class="col-md-4">
        <img src="/assets/images/Sarah.jpg" alt="Sarah - Founder">
        <h5>Sarah</h5>
        <p>Founder & Designer</p>
      </div>
      <div class="col-md-4">
        <img src="/assets/images/Ayesha.jpg" alt="Ayesha - Marketing Lead">
        <h5>Ayesha</h5>
        <p>Marketing Lead</p>
      </div>
      <div class="col-md-4">
        <img src="/assets/images/Diya.jpg" alt="Diya - Customer Care">
        <h5>Diya</h5>
        <p>Customer Care</p>
      </div>
    </div>
  </div>

  <div class="container testimonials text-center mb-5">
    <h2>What Our Customers Say</h2>
    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card p-3">
          <p>“Absolutely love the dresses! Super affordable and stylish for uni events.”</p>
          <strong>- Haniya, Colombo</strong>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-3">
          <p>“Delivery was so fast! Clothes are comfortable and trendy. Highly recommend.”</p>
          <strong>- Meera, Kandy</strong>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center p-5">
    <a href="contact.php" class="btn-shop">Contact us</a>
  </div>

  <footer>
    &copy; 2025 EyeCache. Designed for NSBM students and streetwear lovers worldwide.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/lm.js">
  
</script>
</body>
</html>
