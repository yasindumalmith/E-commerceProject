<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill in all fields';
        redirect('../login.html');
    }
    
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['success'] = 'Login successful!';
        
        if ($user['role'] === 'admin') {
            redirect('../admin/dashboard.php');
        } else {
            redirect('../index.html');
        }
    } else {
        $_SESSION['error'] = 'Invalid email or password';
        redirect('../login.html');
    }
} else {
    redirect('../login.html');
}
?>