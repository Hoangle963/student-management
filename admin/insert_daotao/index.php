<!DOCTYPE html>
<html lang="vi">
<?php include "menu.php"; ?>
<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $malop = $_POST['malop'];
    $mamon = $_POST['mamon'];
    $magv = $_POST['giangvien'];
    $namhoc = $_POST['namhoc'];
    $hocki = $_POST['hocki'];

    // Thực hiện truy vấn để kiểm tra sự tồn tại của malop và mamon trong bảng daotao
    $check_query = "SELECT * FROM daotao WHERE malop = '$malop' AND mamon = '$mamon'";
    $result_check = $conn->query($check_query);

    if ($result_check->num_rows == 0) {
        // Không có bản ghi nào trùng, có thể thêm mới
        $insert_query = "INSERT INTO daotao (malop, mamon, magv, namhoc, hocki) VALUES ('$malop', '$mamon', '$magv', '$namhoc', '$hocki')";

        if ($conn->query($insert_query) === TRUE) {
            $message = "Thêm thành công!";
    
            // Hiển thị alert trước khi chuyển hướng
            echo "<script>alert('$message'); window.location='/qlsv/admin/display_danhsachdaotao';</script>";
            exit();
        } else {
            echo "Lỗi khi thêm thông tin đào tạo: " . $insert_query . "<br>" . $conn->error;
        }
    } else {
        // Bản ghi trùng lặp
        echo "Bản ghi đã tồn tại trong bảng daotao.";
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Đào Tạo</title>
</head>

<body>
    <div class="container mt-5"><br><br><br>
    <h1 class="mb-4">Thêm Đào Tạo</h1>
    <form action="" method="post">
    <div class="form-group">
        <label for="malop">Mã Lớp:</label>
        <select class="form-control" name="malop" required>
            <?php
            require_once("connection.php");
            // Truy vấn để lấy danh sách các lớp từ bảng lop
            $sql_lop = "SELECT malop, tenlop FROM lop";
            $result_lop = $conn->query($sql_lop);
            while ($row_lop = $result_lop->fetch_assoc()) {
                echo "<option value='" . $row_lop["malop"] . "'>" . $row_lop["tenlop"] . "</option>";
            }
            ?>
        </select>
        <br></div>
        <div class="form-group">
        <label for="mamon">Mã Môn:</label>
        <select class="form-control" name="mamon" required>
            <?php
            
            // Truy vấn để lấy danh sách các môn từ bảng monhoc
            $sql_mon = "SELECT mamon, tenmon FROM monhoc";
            $result_mon = $conn->query($sql_mon);
            while ($row_mon = $result_mon->fetch_assoc()) {
                echo "<option value='" . $row_mon["mamon"] . "'>" . $row_mon["tenmon"] . "</option>";
            }
            ?>
        </select>
        <br></div>
        <div class="form-group">
        <label for="giangvien">Giảng Viên:</label>
        <select class="form-control" name="giangvien" required>
            <?php
            
            // Truy vấn để lấy danh sách các giảng viên từ bảng giang_vien
            $sql_gv = "SELECT magv, hoten FROM giang_vien";
            $result_gv = $conn->query($sql_gv);
            while ($row_gv = $result_gv->fetch_assoc()) {
                echo "<option value='" . $row_gv["magv"] . "'>" . $row_gv["hoten"] . "</option>";
            }
            ?>
        </select>
        <br></div>
        <div class="form-group">
        <label for="namhoc">Năm Học:</label>
        <select class="form-control" name="namhoc" required>
        <option value="1">Năm 1</option>
            <option value="2">Năm 2</option>
            <option value="3">Năm 3</option>
            <option value="4">Năm 4</option>
        </select>
        <br></div>
        <div class="form-group">
        <label for="hocki">Học Kì:</label>
        <select class="form-control" name="hocki" required>
            <option value="1">Kì 1</option>
            <option value="2">Kì 2</option>
        </select>
        <br></div>
        <input type="submit" value="Thêm Đào Tạo">
    </form>
</body>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">Báo cáo tốt nghiệp sinh viên trường đại học Tài Nguyên và Môi Trường Hà Nội.</span>
    </div>
</footer>
</html>
