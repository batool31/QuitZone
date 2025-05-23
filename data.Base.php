<?php
$host = "localhost";
$username = "root";    
$password = "";        
$database = "quitzone"; 

// إنشاء الاتصال باستخدام mysqli مع معالجة استثناءات
$conn = new mysqli($host, $username, $password, $database);

// التحقق من الاتصال
if ($conn->connect_error) {
    // لا تستخدم die، بل ارمي استثناء للتعامل معه في الملف الأساسي
    throw new Exception("Database connection failed: " . $conn->connect_error);
}
?>
