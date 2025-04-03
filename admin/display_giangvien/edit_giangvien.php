<!-- edit_giangvien.php -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Giảng Viên</title>
</head>
<?php include "menu.php"; ?>
<body><br><br><br>
<div class="container mt-5">
    <h2 class="mb-4">Sửa Thông Tin Giảng Viên</h2>

    <?php
    require_once("connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];

        // Lấy thông tin giảng viên từ bảng giang_vien
        $sql_giangvien = "SELECT * FROM giang_vien WHERE magv = '$id'";
        $result_giangvien = $conn->query($sql_giangvien);

        if ($result_giangvien->num_rows > 0) {
            $row_giangvien = $result_giangvien->fetch_assoc();

            // Lấy thông tin user từ bảng user
            $sql_user = "SELECT * FROM user WHERE taikhoan = '" . $row_giangvien['magv'] . "'";
            $result_user = $conn->query($sql_user);

            if ($result_user->num_rows > 0) {
                $row_user = $result_user->fetch_assoc();
    ?>
                <form action="update_giangvien.php" method="POST">
                <div class="form-group">
                    <input class="form-control" type="hidden" name="magv" value="<?php echo $row_giangvien['magv']; ?>">
                </div>
                <div class="form-group">
                    <label for="hoten">Họ Tên:</label>
                    <input type="text" class="form-control" name="hoten" value="<?php echo $row_giangvien['hoten']; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="gioitinh">Giới Tính:</label>
                    <select class="form-control" name="gioitinh">
                        <option value="Nam" <?php echo ($row_giangvien['gioitinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                        <option value="Nữ" <?php echo ($row_giangvien['gioitinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                        <option value="Khác" <?php echo ($row_giangvien['gioitinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                    </select><br>
                </div>
                <div class="form-group">
                    <label for="ngaysinh">Ngày Sinh:</label>
                    <input type="date" class="form-control" name="ngaysinh" value="<?php echo $row_giangvien['ngaysinh']; ?>"><br>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" value="<?php echo $row_giangvien['email']; ?>"><br>
                </div>
                    <!-- Hiển thị trường mật khẩu mà không cần chọn -->
                    <div class="form-group">
                    <label for="mat_khau">Mật Khẩu:</label>
                    <input type="text" class="form-control" name="mat_khau" value="<?php echo $row_user['mat_khau']; ?>"><br>
                    </div>
                    <input type="submit" value="Lưu">
                </form>
    <?php
            } else {
                echo "Không tìm thấy thông tin user.";
            }
        } else {
            echo "Không tìm thấy giảng viên.";
        }
    }

    $conn->close();
    ?>
</body>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">Báo cáo tốt nghiệp sinh viên trường đại học Tài Nguyên và Môi Trường Hà Nội.</span>
    </div>
</footer>
</html>
