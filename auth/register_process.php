<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill in all required fields';
        redirect('../register.html');
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match';
        redirect('../register.html');
    }
    
    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters long';
        redirect('../register.html');
    }
    
    $pdo = getConnection();
    
    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Username or email already exists';
        redirect('../register.html');
    }
    
    // Hash password and insert user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, phone, address, password) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$full_name, $username, $email, $phone, $address, $hashed_password])) {
        $_SESSION['success'] = 'Registration successful! Please login.';
        redirect('../login.html');
    } else {
        $_SESSION['error'] = 'Registration failed. Please try again.';
        redirect('../register.html');
    }
} else {
    redirect('../register.html');
}
?>