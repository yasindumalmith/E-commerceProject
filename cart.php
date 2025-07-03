<?php
require_once 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - MarketPlace</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <h2>MarketPlace</h2>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="cart.php">Cart (<span id="cart-count">0</span>)</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="register.html">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="cart-container">
            <h1>Shopping Cart</h1>
            
            <div id="cart-items">
                <!-- Cart items will be loaded here by JavaScript -->
            </div>
            
            <div id="cart-total" class="cart-total">
                <!-- Cart total will be displayed here -->
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <a href="products.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 MarketPlace. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script>
        // Load cart items when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadCartItems();
        });
    </script>
</body>
</html>