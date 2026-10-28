<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kiểm tra điểm hợp lệ</title>
</head>
<body>
    <h2>Nhập điểm cần kiểm tra (từ 0 đến 10)</h2>
    
    <!-- Form nhập điểm dùng phương thức GET hoặc POST -->
    <form method="GET" action="">
        <input type="text" name="diem" placeholder="Nhập điểm..." value="<?php echo isset($_GET['diem']) ? htmlspecialchars($_GET['diem']) : ''; ?>">
        <button type="submit">Kiểm tra</button>
    </form>

    <br>

    <?php
    // Kiểm tra xem người dùng đã bấm gửi điểm lên chưa
    if (isset($_GET['diem'])) {
        $diem = $_GET['diem'];

        // Kiểm tra xem ô input có bị để trống không
        if ($diem === "") {
            echo "<p style='color: orange;'>Vui lòng nhập vào một số điểm!</p>";
        } 
        // Biểu thức kiểm tra: là số VÀ nằm trong khoảng từ 0 đến 10
        elseif (is_numeric($diem) && $diem >= 0 && $diem <= 10) {
            echo "<p style='color: green; font-weight: bold;'>Điểm $diem hợp lệ!</p>";
        } else {
            echo "<p style='color: red; font-weight: bold;'>Điểm $diem không hợp lệ!</p>";
        }
    }
    ?>
</body>
</html>