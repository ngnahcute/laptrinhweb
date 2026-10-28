<?php
// Khởi tạo mảng lưu lỗi và mảng lưu dữ liệu cũ theo đúng yêu cầu bài học
$errors = [];
$data = ['name' => '', 'email' => '', 'birthday' => ''];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form gửi lên qua POST
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['birthday'] = trim($_POST['birthday'] ?? '');

    // Kiểm tra bắt buộc: Họ tên
    if ($data['name'] === '') {
        $errors['name'] = 'Vui lòng nhập họ tên';
    }

    // Kiểm tra bắt buộc và định dạng email hợp lệ bằng filter_var()
    if ($data['email'] === '') {
        $errors['email'] = 'Vui lòng nhập email';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    }

    // Kiểm tra bắt buộc: Ngày sinh
    if ($data['birthday'] === '') {
        $errors['birthday'] = 'Vui lòng nhập ngày sinh';
    }

    // Nếu không có lỗi nào -> Đánh dấu thành công
    if (empty($errors)) {
        $success = true;
    }
}

// Hàm mã hóa đầu ra chống XSS
function e($v) { 
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); 
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>3.7 Demo: Form đăng ký sinh viên</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f9fa; margin: 40px; }
        .box { max-width: 500px; background: #fff; margin: 0 auto; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="date"] { width: 100%; padding: 9px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .error { color: #d9534f; font-size: 13px; margin-top: 4px; display: block; }
        .success { background: #dff0d8; color: #3c763d; padding: 15px; border-radius: 4px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .btn { width: 100%; background: #0275d8; color: white; border: none; padding: 11px; font-size: 15px; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #025aa5; }
    </style>
</head>
<body>

<div class="box">
    <h2>Đăng ký sinh viên</h2>

    <!-- Hiển thị thông báo khi đăng ký thành công -->
    <?php if ($success): ?>
        <div class="success">
            Đăng ký sinh viên thành công!<br>
            Hệ thống đã xác thực thông tin hợp lệ.
        </div>
        <p style="text-align: center;"><a href="">Đăng ký sinh viên khác</a></p>
    <?php else: ?>
        <!-- Form nhập liệu -->
        <form action="" method="POST">
            <!-- Họ tên -->
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="name" value="<?php echo e($data['name']); ?>">
                <?php if (isset($errors['name'])): ?>
                    <span class="error"><?php echo $errors['name']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo e($data['email']); ?>">
                <?php if (isset($errors['email'])): ?>
                    <span class="error"><?php echo $errors['email']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Ngày sinh -->
            <div class="form-group">
                <label>Ngày sinh:</label>
                <input type="date" name="birthday" value="<?php echo e($data['birthday']); ?>">
                <?php if (isset($errors['birthday'])): ?>
                    <span class="error"><?php echo $errors['birthday']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Nút submit -->
            <button type="submit" class="btn">Đăng ký</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>