<?php
session_start();
session_unset();     // حذف كل المتغيرات من الجلسة
session_destroy();   // إنهاء الجلسة بالكامل

header("Location: login.php"); // إعادة توجيه إلى صفحة تسجيل الدخول
exit();
?>
