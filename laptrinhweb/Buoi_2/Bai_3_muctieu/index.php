<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Ví dụ Bảo Mật Form</title>
</head>
<body>
    <h2>Đăng ký thông tin</h2>

    <!-- Hiển thị thông báo lỗi từ server nếu có -->
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <!-- Form gửi dữ liệu bằng phương thức POST đến file xu_ly.php -->
    <form action="xu_ly.php" method="POST">
        <div>
            <label>Họ tên:</label><br>
            <!-- Thêm thuộc tính required vào đây -->
            <input type="text" name="hoten" value="<?php echo isset($_GET['hoten']) ? htmlspecialchars($_GET['hoten']) : ''; ?>" required>
        </div>
        <br>
        <div>
            <label>Email:</label><br>
            <!-- Thêm thuộc tính required vào đây -->
            <input type="text" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>
        </div>
        <br>
        <button type="submit">Gửi dữ liệu</button>
    </form>
</body>
</html>