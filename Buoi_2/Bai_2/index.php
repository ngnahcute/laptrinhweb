<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phân biệt GET và POST trong PHP</title>
</head>
<body>
    <h2>1. Tìm kiếm sinh viên (Dùng phương thức GET)</h2>
    <!-- method="GET" sẽ đính kèm từ khóa tìm kiếm lên URL -->
    <form action="tim_kiem.php" method="GET">
        <label>Nhập tên tìm kiếm:</label>
        <input type="text" name="keyword" required>
        <button type="submit">Tìm kiếm</button>
    </form>

    <hr>

    <h2>2. Thêm sinh viên mới (Dùng phương thức POST)</h2>
    <!-- method="POST" sẽ giấu dữ liệu đi, an toàn hơn -->
    <form action="them_sv.php" method="POST">
        <label>Họ tên sinh viên:</label>
        <input type="text" name="ten_sv" required><br><br>
        <label>Email:</label>
        <input type="text" name="email_sv" required><br><br>
        <button type="submit">Thêm mới</button>
    </form>
</body>
</html>