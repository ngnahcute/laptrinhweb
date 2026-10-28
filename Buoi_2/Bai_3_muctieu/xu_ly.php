<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = trim($_POST['hoten']);
    $email = trim($_POST['email']);

    // Cho phép gửi thoải mái, không chặn lỗi nữa
    echo "<h2>Đã nhận dữ liệu thành công!</h2>";
    echo "Họ tên: " . htmlspecialchars($hoten) . "<br>";
    echo "Email: " . htmlspecialchars($email);
}
?>