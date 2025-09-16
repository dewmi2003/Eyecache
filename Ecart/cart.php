<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart - EyeCache</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

  body { font-family:'Poppins',sans-serif; background:#111; color:#eee; padding:20px; }
  #cart-container { max-width:700px; margin:100px auto; background:#222; padding:20px; border-radius:12px; box-shadow:0 0 20px rgba(255,60,120,0.3); overflow:hidden; }
  .navbar {
      background-color: #111 !important;
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
    }

    .navbar-nav .nav-link:hover {
      color: #ff4c80 !important;
    }

  h2 { color:#ff3c78; text-align:center; margin-bottom:20px; }
  .cart-item { display:flex; align-items:center; justify-content:space-between; background:#1a1a1a; margin-bottom:12px; border-radius:10px; padding:10px; transition: transform 0.2s, box-shadow 0.2s, opacity 0.3s; }
  .cart-item:hover { transform:scale(1.02); box-shadow:0 0 15px rgba(255,60,120,0.4); }
  .cart-item img { width:60px; height:60px; border-radius:8px; object-fit:cover; margin-right:15px; }
  .cart-details { flex:1; }
  .cart-details h4 { margin:0 0 5px 0; font-size:1rem; }
  .cart-details p { margin:0; font-size:0.9rem; color:#ccc; }
  .cart-actions { display:flex; align-items:center; gap:10px; }
  .cart-actions input { width:50px; text-align:center; border-radius:6px; border:none; padding:4px; }
  .cart-actions button { background:#ff3c78; border:none; padding:6px 12px; border-radius:8px; color:white; font-weight:bold; cursor:pointer; transition: background 0.2s; }
  .cart-actions button:hover { background:#e62d65; }
  #cart-summary { margin-top:20px; text-align:right; font-size:1.1rem; }
  #checkout-btn { display:block; width:100%; margin-top:15px; padding:12px 0; font-size:1rem; border-radius:30px; border:none; background:#ff3c78; font-weight:bold; cursor:pointer; transition:background 0.3s; }
  #checkout-btn:hover { background:#e62d65; }
  #checkout-form { display:none; margin-top:20px; background:#1b1b1b; padding:20px; border-radius:12px; animation:fadeIn 0.5s ease-in-out; }
  #checkout-form input, #checkout-form label { display:block; width:100%; margin-bottom:12px; color:#eee; }
  #checkout-form input { padding:8px; border-radius:6px; border:none; background:#333; color:#eee; }
  #checkout-form h3, #checkout-form h4 { color:#ff3c78; margin-bottom:10px; }
  #pay-btn { background:#ff3c78; color:white; border:none; padding:10px; border-radius:25px; width:100%; font-weight:bold; cursor:pointer; transition:background 0.3s; }
  #pay-btn:hover { background:#e62d65; }
  #card-form { display:none; margin-top:15px; }
  @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }
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
      <li class="nav-item"><a href="#cart" class="nav-link"><i class="fas fa-shopping-cart"></i> Cart</a></li>
      <li class="nav-item"><a href="#user" class="nav-link"><i class="fas fa-user"></i> User</a></li>
      <li class="nav-item"><a href="#about" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
      <li class="nav-item"><a href="#contact" class="nav-link"><i class="fas fa-envelope"></i> Contact</a></li>
    </ul>
  </div>
</nav>
<div id="cart-container">
  <h2>🛍️ My Cart</h2>
  <div id="cart-items"></div>
  <div id="cart-summary"></div>
  <button id="checkout-btn">Checkout</button>
  <div id="checkout-form"></div>
</div>

<script>
async function fetchCart() {
  const res = await fetch('get_cart.php');
  return await res.json();
}

async function updateCart(product_id, quantity) {
  await fetch('update_cart.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:`product_id=${product_id}&quantity=${quantity}`
  });
  loadCart();
}

async function removeItem(cart_id) {
  await fetch('remove_cart.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:`cart_id=${cart_id}`
  });
  loadCart();
}

function showCheckoutForm() {
  const formDiv = document.getElementById('checkout-form');
  formDiv.style.display = 'block';
  formDiv.innerHTML = `
    <h3>Checkout Details</h3>
    <label>Address</label><input type="text" id="address" placeholder="Enter your address" required>
    <label>Name</label><input type="text" id="name" placeholder="Enter your name" required>
    <label>Telephone</label><input type="tel" id="tel" placeholder="Enter your number" required>
    <h4>Payment Method</h4>
    <label><input type="radio" name="payment" value="card" required> Credit / Debit Card</label>
    <label><input type="radio" name="payment" value="cod"> Cash on Delivery</label>
    <button id="pay-btn">PAY</button>
    <div id="card-form"></div>
  `;
  document.getElementById('pay-btn').addEventListener('click',()=>{ alert('Payment processing...'); });
  document.querySelectorAll('input[name="payment"]').forEach(r=>{
    r.addEventListener('change',function(){
      const cardDiv=document.getElementById('card-form');
      if(this.value==='card'){
        cardDiv.style.display='block';
        cardDiv.innerHTML=`<h4>Card Details</h4>
          <label>Card Name</label><input type="text" id="card-name">
          <label>Card Number</label><input type="text" id="card-number" maxlength="16">
          <label>Expiry</label><input type="month" id="card-expiry">
          <label>CVV</label><input type="password" id="card-cvv" maxlength="3">`;
      }else{ cardDiv.style.display='none'; }
    });
  });
}

document.getElementById('checkout-btn').addEventListener('click', showCheckoutForm);

async function loadCart() {
  const cart = await fetchCart();
  const container = document.getElementById('cart-items');
  const summary = document.getElementById('cart-summary');
  container.innerHTML='';

  if(cart.length===0){
    container.innerHTML='<p style="text-align:center; color:#aaa;">Your cart is empty!</p>';
    summary.textContent='';
    return;
  }

  let total=0;
  cart.forEach(item=>{
    total += item.price*item.quantity;
    const div=document.createElement('div');
    div.className='cart-item';
    div.innerHTML=`
      <img src="${item.image}" alt="${item.name}">
      <div class="cart-details">
        <h4>${item.name}</h4>
        <p>Rs. ${item.price} x ${item.quantity} = Rs. ${item.price*item.quantity}</p>
      </div>
      <div class="cart-actions">
        <input type="number" min="1" value="${item.quantity}" onchange="updateCart(${item.product_id},this.value)">
        <button onclick="removeItem(${item.cart_id})">❌</button>
      </div>
    `;
    container.appendChild(div);
  });

  let shipping = total>3000?0:(total>0?200:0);
  summary.textContent=`Subtotal: Rs. ${total} | Shipping: Rs. ${shipping} | Total: Rs. ${total+shipping}`;
}

loadCart();
</script>
</body>
</html>
