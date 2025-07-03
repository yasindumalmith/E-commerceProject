// Global variables
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Update cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    loadFeaturedProducts();
});

// Update cart count in navigation
function updateCartCount() {
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
    }
}

// Add product to cart
function addToCart(productId, productName, productPrice, productImage) {
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: parseFloat(productPrice),
            image: productImage,
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showAlert('Product added to cart!', 'success');
}

// Remove item from cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    loadCartItems();
}

// Update quantity in cart
function updateQuantity(productId, newQuantity) {
    if (newQuantity <= 0) {
        removeFromCart(productId);
        return;
    }
    
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = newQuantity;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        loadCartItems();
    }
}

// Load featured products on homepage
function loadFeaturedProducts() {
    const featuredContainer = document.getElementById('featured-products');
    if (!featuredContainer) return;
    
    // This would typically fetch from your PHP backend
    // For demo purposes, we'll use sample data
    const sampleProducts = [
        {
            id: 1,
            name: 'Smartphone',
            price: 299.99,
            image: '/placeholder.svg?height=200&width=200',
            description: 'Latest Android smartphone'
        },
        {
            id: 2,
            name: 'Laptop',
            price: 899.99,
            image: '/placeholder.svg?height=200&width=200',
            description: 'High-performance laptop'
        },
        {
            id: 3,
            name: 'T-Shirt',
            price: 19.99,
            image: '/placeholder.svg?height=200&width=200',
            description: 'Comfortable cotton t-shirt'
        }
    ];
    
    featuredContainer.innerHTML = sampleProducts.map(product => `
        <div class="product-card">
            <img src="${product.image}" alt="${product.name}">
            <h3>${product.name}</h3>
            <p>${product.description}</p>
            <div class="product-price">$${product.price}</div>
            <button class="btn btn-success" onclick="addToCart(${product.id}, '${product.name}', ${product.price}, '${product.image}')">
                Add to Cart
            </button>
        </div>
    `).join('');
}

// Load cart items on cart page
function loadCartItems() {
    const cartContainer = document.getElementById('cart-items');
    if (!cartContainer) return;
    
    if (cart.length === 0) {
        cartContainer.innerHTML = '<p>Your cart is empty.</p>';
        document.getElementById('cart-total').innerHTML = '';
        return;
    }
    
    cartContainer.innerHTML = cart.map(item => `
        <div class="cart-item">
            <img src="${item.image}" alt="${item.name}">
            <div class="cart-item-details">
                <h4>${item.name}</h4>
                <div class="cart-item-price">$${item.price}</div>
                <div class="quantity-controls">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                    <span>Qty: ${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                </div>
            </div>
            <button class="btn btn-danger" onclick="removeFromCart(${item.id})">Remove</button>
        </div>
    `).join('');
    
    // Calculate and display total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('cart-total').innerHTML = `
        <h3>Total: $${total.toFixed(2)}</h3>
        <button class="btn btn-primary" onclick="checkout()">Proceed to Checkout</button>
    `;
}

// Checkout function
function checkout() {
    if (cart.length === 0) {
        showAlert('Your cart is empty!', 'error');
        return;
    }
    
    // Redirect to checkout page or show checkout form
    window.location.href = 'checkout.php';
}

// Show alert messages
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    document.body.insertBefore(alertDiv, document.body.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            input.style.borderColor = '#ddd';
        }
    });
    
    return isValid;
}

// Search functionality
function searchProducts(query) {
    // This would typically send a request to your PHP backend
    console.log('Searching for:', query);
}