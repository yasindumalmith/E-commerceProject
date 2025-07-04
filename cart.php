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
    <footer>
        <div class="container">
            <div class="footer-columns">
                <!-- First Column: Brand Info -->
                <div class="footer-column">
                    <h3>MarketPlace</h3>
                    <p>Your one-stop online shop for all your needs.</p>

                    <h3 class="newsletter-heading">Newsletter</h3>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
                
                <!-- Second Column: Quick Links -->
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Third Column: Contact & Newsletter -->
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Market St, Colombo, Sri Lanka</li>
                        <li><i class="fas fa-phone"></i> +94 234 567 890</li>
                        <li><i class="fas fa-envelope"></i> info@marketplace.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Fri: 9AM - 6PM</li>
                    </ul>
                </div>
            </div>
            
            <!-- Follow Us Section (Now at bottom) -->
            <div class="follow-us-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; <span id="copyright-year"></span> MarketPlace. All rights reserved.</p>
            </div>
        </div>
        <script src="assets/js/script.js"></script>
    </footer>

    <script>
        // Update the copyright year dynamically
        document.getElementById('copyright-year').textContent = new Date().getFullYear();
    </script>
    <script src="js/script.js"></script>
</body>
</html>