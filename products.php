<?php
require_once 'config/database.php';

$pdo = getConnection();

// Get categories for filter
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Get products with optional category filter
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT p.*, c.name as category_name FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];

if ($categoryFilter) {
    $sql .= " AND p.category_id = ?";
    $params[] = $categoryFilter;
}

if ($searchQuery) {
    $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%$searchQuery%";
    $params[] = "%$searchQuery%";
}

$sql .= " ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - MarketPlace</title>
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
        <div class="container" style="margin-top: 100px;">
            <h1>Our Products</h1>
            
            <!-- Search and Filter -->
            <div class="filters" style="margin: 2rem 0;">
                <form method="GET" style="display: flex; gap: 1rem; align-items: center;">
                    <input type="text" name="search" placeholder="Search products..." 
                           value="<?php echo htmlspecialchars($searchQuery); ?>" 
                           style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    
                    <select name="category" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                    <?php echo $categoryFilter == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo $product['image_url'] ?: '/placeholder.svg?height=200&width=200'; ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                        <p>Stock: <?php echo $product['stock_quantity']; ?></p>
                        <p>Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
                        
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <button class="btn btn-success" 
                                    onclick="addToCart(<?php echo $product['id']; ?>, 
                                                     '<?php echo addslashes($product['name']); ?>', 
                                                     <?php echo $product['price']; ?>, 
                                                     '<?php echo $product['image_url'] ?: '/placeholder.svg?height=200&width=200'; ?>')">
                                Add to Cart
                            </button>
                        <?php else: ?>
                            <button class="btn" disabled style="background: #ccc;">Out of Stock</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (empty($products)): ?>
                <p style="text-align: center; margin: 2rem 0;">No products found.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 MarketPlace. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>