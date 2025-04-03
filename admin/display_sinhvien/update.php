<!DOCTYPE html>
<html lang="vi">
 <?php include "menu.php"; ?>
<?php
// update.php

require_once("connection.php");

// Kiểm tra xem có mã sinh viên được chọn không
if (isset($_GET['masv'])) {
    $masv = $_GET['masv'];

    // Lấy thông tin sinh viên từ cơ sở dữ liệu
    $sql = "SELECT * FROM sinh_vien WHERE masv = '$masv'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy sinh viên có mã: $masv";
        exit(); // Thoát khỏi trang nếu không tìm thấy sinh viên
    }
} else {
    echo "Mã sinh viên không được cung cấp.";
    exit(); // Thoát khỏi trang nếu không có mã sinh viên
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sinh Viên</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Sự kiện khi người dùng thay đổi nganhhoc hoặc khoahoc
            $("#nganhhoc, #khoahoc").change(function () {
                updateClassList();
            });

            // Hàm cập nhật danh sách lớp
            function updateClassList() {
                var nganhhoc = $("#nganhhoc").val();
                var khoahoc = $("#khoahoc").val();

                // Gửi yêu cầu AJAX để lấy danh sách lớp từ server
                $.ajax({
                    type: "POST",
                    url: "get_class_list.php",
                    data: { nganhhoc: nganhhoc, khoahoc: khoahoc },
                    success: function (response) {
                        $("#class-list-container").html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Lỗi khi tải danh sách lớp. Kiểm tra Console để biết chi tiết.");
                    }
                });
            }

            // Gọi hàm cập nhật danh sách lớp khi trang được tải
            updateClassList();
        });
    </script>
</head>

<body>
    <h1>Sửa Sinh Viên</h1>
    <form action="process_update.php" method="post">
    <div class="container mt-4">
  
            <input type="hidden" name="masv" value="<?php echo $row['masv']; ?>">
            <div class="form-group">
                <label for="hoten">Họ và Tên:</label>
                <input type="text" class="form-control" name="hoten" value="<?php echo $row['hoten']; ?>" required>
            </div>

            <div class="form-group">
        <label for="gioitinh">Giới Tính:</label>
        <select class="form-control" name="gioitinh" required>
            <option value="Nam"  <?php echo ($row['gioitinh'] == 'Nam' ? 'selected' : ''); ?>>Nam</option>
            <option value="Nữ" <?php echo ($row['gioitinh'] == 'Nữ' ? 'selected' : ''); ?>>Nữ</option>
        </select></div>
        <br>
        <div class="form-group">
        <label for="Ngaysinh">Ngày Sinh:</label>
        <input type="date" class="form-control" name="Ngaysinh" value="<?php echo $row['Ngaysinh']; ?>" required>
        <br></div>
        <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
        <br>
        </div>
        <label for="nganhhoc">Ngành Học:</label>
        <select name="nganhhoc" class="form-control" id="nganhhoc" required>
            <!-- Load danh sách ngành học từ cơ sở dữ liệu -->
            <?php
            $sql_nganh = "SELECT ma_nh, ten_nganh FROM nganh_hoc";
            $result_nganh = $conn->query($sql_nganh);
            while ($row_nganh = $result_nganh->fetch_assoc()) {
                echo "<option value='" . $row_nganh["ma_nh"] . "' " . ($row['ma_nh'] == $row_nganh["ma_nh"] ? 'selected' : '') . ">" . $row_nganh["ten_nganh"] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="khoahoc">Khóa Học:</label>
        <select name="khoahoc" class="form-control" id="khoahoc" required>
            <!-- Load danh sách khóa học từ cơ sở dữ liệu -->
            <?php
            $sql_khoa = "SELECT id_khoa, namhoc FROM khoa_hoc";
            $result_khoa = $conn->query($sql_khoa);
            while ($row_khoa = $result_khoa->fetch_assoc()) {
                echo "<option value='" . $row_khoa["id_khoa"] . "' " . ($row['id_khoa'] == $row_khoa["id_khoa"] ? 'selected' : '') . ">" . $row_khoa["namhoc"] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="malop"></label>
        <div  id="class-list-container">
            <!-- Danh sách lớp sẽ được cập nhật tại đây -->
        </div>
        <br>
        <input type="submit" value="Lưu Sửa Đổi">
    </form>
</body>

</html>
