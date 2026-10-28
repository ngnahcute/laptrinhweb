<?php
$thong_bao = "";
$duong_dan_anh = "";

// Xử lý khi người dùng bấm nút Submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];

    // 1. Kiểm tra lỗi hệ thống upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $thong_bao = "<p style='color: red;'>Lỗi: Không thể tải lên file. Mã lỗi: " . $file['error'] . "</p>";
    } 
    // 2. Kiểm tra kích thước file (Tối đa 2MB = 2 * 1024 * 1024 bytes)
    elseif ($file['size'] > 2 * 1024 * 1024) {
        $thong_bao = "<p style='color: red;'>Lỗi: Kích thước file quá lớn! Dung lượng tối đa cho phép là 2MB.</p>";
    } 
    else {
        // 3. Kiểm tra phần mở rộng (Extension) hợp lệ
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($file_extension, $allowed_extensions)) {
            $thong_bao = "<p style='color: red;'>Lỗi: Định dạng file không được phép! Chỉ chấp nhận file JPG, JPEG, PNG.</p>";
        } else {
            // 4. Kiểm tra MIME type thực tế của file bằng hàm chuyên dụng
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            $allowed_mimes = ['image/jpeg', 'image/png'];
            if (!in_array($mime_type, $allowed_mimes)) {
                $thong_bao = "<p style='color: red;'>Lỗi: Nội dung file không phải là ảnh hợp lệ!</p>";
            } else {
                // 5. Đổi tên file mới hoàn toàn an toàn để tránh ghi đè và tránh mã độc
                $new_filename = uniqid('avatar_', true) . '.' . $file_extension;
                
                // Thư mục lưu trữ (Đảm bảo thư mục 'uploads' đã tồn tại cùng cấp với file này)
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $destination = $upload_dir . $new_filename;

                // 6. Di chuyển file từ thư mục tạm lên thư mục chính thức của server
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $thong_bao = "<p style='color: green;'><b>Upload ảnh đại diện thành công!</b></p>";
                    $duong_dan_anh = $destination;
                } else {
                    $thong_bao = "<p style='color: red;'>Lỗi hệ thống: Không thể lưu file vào thư mục đích.</p>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload Ảnh Đại Diện An Toàn</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 500px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fdfdfd; }
        img { margin-top: 15px; border-radius: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Upload Ảnh Đại Diện An Toàn</h2>

    <!-- Hiển thị thông báo kết quả -->
    <?php echo $thong_bao; ?>

    <!-- Form tự gửi dữ liệu lại chính file này (action="") -->
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Chọn file ảnh (Chỉ nhận JPG, PNG - Tối đa 2MB):</label><br><br>
        <input type="file" name="avatar" required><br><br>
        <button type="submit">Tải lên</button>
    </form>

    <!-- Hiển thị ảnh sau khi upload thành công -->
    <?php if (!empty($duong_dan_anh)): ?>
        <hr>
        <p>Ảnh đại diện của bạn:</p>
        <img src="<?php echo htmlspecialchars($duong_dan_anh); ?>" width="200">
    <?php endif; ?>
</div>

</body>
</html>