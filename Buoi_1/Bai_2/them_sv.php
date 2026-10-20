<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu an toàn từ form POST
    $tensv = trim($_POST['ten_sv']);
    $emailsv = trim($_POST['email_sv']);

    // Kiểm tra dữ liệu (Validation cơ bản)
    if (empty($tensv) || empty($emailsv)) {
        echo "Lỗi: Không được để trống dữ liệu!";
    } else {
        // Xử lý lưu vào Database thành công ở đây...
        echo "<h3>Thêm sinh viên thành công!</h3>";
        echo "Họ tên: " . htmlspecialchars($tensv) . "<br>";
        echo "Email: " . htmlspecialchars($emailsv) . "<br>";
    }
}
?>
<br><a href="index.php">Quay lại trang chủ</a>