<?php
// Kiểm tra xem có dữ liệu keyword gửi lên qua URL không
if (isset($_GET['keyword'])) {
    $tukhoa = trim($_GET['keyword']);
    echo "<h3>Kết quả tìm kiếm cho từ khóa: " . htmlspecialchars($tukhoa) . "</h3>";
    // (Ở đây bạn có thể viết câu lệnh SQL SELECT để tìm kiếm trong CSDL)
} else {
    echo "Chưa có từ khóa tìm kiếm!";
}
?>
<br><a href="index.php">Quay lại trang chủ</a>