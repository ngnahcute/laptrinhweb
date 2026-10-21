<?php
// Khởi tạo các mảng dữ liệu và lỗi theo đúng chuẩn mô hình bài học
$errors = [];
$data = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'content' => ''
];
$thong_bao_thanh_cong = "";
$duong_dan_anh = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Nhận và làm sạch dữ liệu từ form POST
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['subject'] = $_POST['subject'] ?? '';
    $data['content'] = trim($_POST['content'] ?? '');

    // 2. Kiểm tra bắt buộc các trường không được rỗng
    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên.';
    }
    
    if ($data['email'] === '') {
        $errors['email'] = 'Vui lòng nhập email.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        // 3. Kiểm tra định dạng email hợp lệ
        $errors['email'] = 'Email không hợp lệ.';
    }

    if ($data['content'] === '') {
        $errors['content'] = 'Vui lòng nhập nội dung liên hệ.';
    } elseif (mb_strlen($data['content']) < 10) {
        $errors['content'] = 'Nội dung phải từ 10 ký tự trở lên.';
    }

    // 4. Xử lý và kiểm tra bảo mật cho Upload ảnh đại diện (3 kiểm tra bắt buộc)
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['avatar'];

        // Kiểm tra lỗi upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['avatar'] = 'Lỗi hệ thống khi tải file lên.';
        } 
        // Kiểm tra kích thước file (Tối đa 2MB)
        elseif ($file['size'] > 2 * 1024 * 1024) {
            $errors['avatar'] = 'Kích thước file quá lớn (Tối đa 2MB).';
        } else {
            // Kiểm tra phần mở rộng (Extension)
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file_extension, $allowed_extensions)) {
                $errors['avatar'] = 'Chỉ chấp nhận file định dạng JPG, JPEG, PNG.';
            } else {
                // Kiểm tra MIME type thực tế bằng finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                $allowed_mimes = ['image/jpeg', 'image/png'];
                if (!in_array($mime_type, $allowed_mimes)) {
                    $errors['avatar'] = 'Nội dung file không phải là ảnh hợp lệ.';
                } else {
                    // Đổi tên file mới an toàn, tránh trùng lặp và mã độc
                    $new_filename = uniqid('avatar_', true) . '.' . $file_extension;
                    $upload_dir = 'uploads/';
                    
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    $destination = $upload_dir . $new_filename;
                    if (move_uploaded_file($file['tmp_name'], $destination)) {
                        $duong_dan_anh = $destination;
                    } else {
                        $errors['avatar'] = 'Không thể lưu file vào thư mục đích.';
                    }
                }
            }
        }
    }

    // 5. Nếu không có lỗi nào xảy ra -> Xử lý thành công
    if (empty($errors)) {
        $thong_bao_thanh_cong = "Gửi liên hệ và upload ảnh thành công!";
    }
}

// Hàm mã hóa chống XSS theo chuẩn bài học
function e($v) { 
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); 
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form Liên Hệ Tổng Hợp</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 40px; }
        .form-container { max-width: 600px; background: #fff; margin: 0 auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        .subtitle { text-align: center; color: #666; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #444; }
        input[type="text"], input[type="file"], select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        textarea { resize: vertical; height: 100px; }
        .error { color: #d9534f; font-size: 14px; margin-top: 5px; display: block; }
        .success { background: #dff0d8; color: #3c763d; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .btn-submit { width: 100%; background: #2e6da4; color: white; border: none; padding: 12px; font-size: 16px; border-radius: 5px; cursor: pointer; }
        .btn-submit:hover { background: #204d74; }
        .preview-img { margin-top: 10px; max-width: 150px; border-radius: 5px; border: 1px solid #ccc; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Liên hệ</h2>
    <p class="subtitle">Vui lòng nhập đầy đủ thông tin bên dưới.</p>

    <!-- Hiển thị thông báo thành công -->
    <?php if ($thong_bao_thanh_cong): ?>
        <div class="success"><?php echo $thong_bao_thanh_cong; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        
        <!-- Họ tên -->
        <div class="form-group">
            <label>Họ tên</label>
            <input type="text" name="name" value="<?php echo e($data['name']); ?>">
            <?php if (isset($errors['name'])): ?>
                <span class="error"><?php echo $errors['name']; ?></span>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="<?php echo e($data['email']); ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error"><?php echo $errors['email']; ?></span>
            <?php endif; ?>
        </div>

        <!-- Chủ đề -->
        <div class="form-group">
            <label>Chủ đề</label>
            <select name="subject">
                <option value="Hỗ trợ kỹ thuật" <?php if($data['subject'] == 'Hỗ trợ kỹ thuật') echo 'selected'; ?>>Hỗ trợ kỹ thuật</option>
                <option value="Đóng góp ý kiến" <?php if($data['subject'] == 'Đóng góp ý kiến') echo 'selected'; ?>>Đóng góp ý kiến</option>
                <option value="Hợp tác kinh doanh" <?php if($data['subject'] == 'Hợp tác kinh doanh') echo 'selected'; ?>>Hợp tác kinh doanh</option>
            </select>
        </div>

        <!-- Nội dung -->
        <div class="form-group">
            <label>Nội dung</label>
            <textarea name="content" placeholder="Nhập nội dung liên hệ..."><?php echo e($data['content']); ?></textarea>
            <?php if (isset($errors['content'])): ?>
                <span class="error"><?php echo $errors['content']; ?></span>
            <?php endif; ?>
        </div>

        <!-- Upload ảnh đại diện (Có 3 kiểm tra bắt buộc) -->
        <div class="form-group">
            <label>Ảnh đại diện (Chỉ nhận JPG, PNG - Tối đa 2MB)</label>
            <input type="file" name="avatar">
            <?php if (isset($errors['avatar'])): ?>
                <span class="error"><?php echo $errors['avatar']; ?></span>
            <?php endif; ?>
            
            <?php if ($duong_dan_anh): ?>
                <br>
                <img src="<?php echo e($duong_dan_anh); ?>" class="preview-img">
            <?php endif; ?>
        </div>

        <!-- Nút gửi -->
        <button type="submit" class="btn-submit">Gửi liên hệ</button>
    </form>
</div>

</body>
</html>