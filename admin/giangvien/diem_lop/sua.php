<?php
require_once("connection.php");
session_start();
include "menu.php";
// Kiểm tra xem masv và mamon có được truyền từ trang trước không
if (isset($_GET['masv']) && isset($_GET['mamon'])) {
    $masv = $_GET['masv'];
    $mamon = $_GET['mamon'];

    // Kiểm tra xem có dữ liệu điểm cho sinh viên không
    $sqlCheckDiem = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
    $resultCheckDiem = $conn->query($sqlCheckDiem);

    if ($resultCheckDiem->num_rows > 0) {
        // Nếu có dữ liệu, hiển thị form cập nhật
        $rowDiem = $resultCheckDiem->fetch_assoc();
        $diem1 = $rowDiem['diem1'];
        $diem2 = $rowDiem['diem2'];
        $diemthi = $rowDiem['diemthi'];
        $diemtbm = $rowDiem['diemtbm'];
    } else {
        // Nếu không có dữ liệu, hiển thị form thêm mới
        $diem1 = $diem2 = $diemthi = $diemtbm = "";
    }

    // Xử lý khi form được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $diem1 = $_POST['diem1'];
        $diem2 = $_POST['diem2'];
        $diemthi = $_POST['diemthi'];

        // Tính điểm trung bình môn
        $diemtbm = (($diem1 + $diem2) / 2) * 0.4 + $diemthi * 0.6;

        // Kiểm tra xem đã có dữ liệu điểm cho sinh viên chưa
        if ($resultCheckDiem->num_rows > 0) {
            // Nếu có, thực hiện cập nhật dữ liệu điểm
            $sqlUpdateDiem = "UPDATE diem SET diem1 = '$diem1', diem2 = '$diem2', diemthi = '$diemthi', diemtbm = '$diemtbm' WHERE masv = '$masv' AND mamon = '$mamon'";
            $conn->query($sqlUpdateDiem);
        } else {
            // Nếu không, thực hiện chèn mới dữ liệu điểm
            $sqlInsertDiem = "INSERT INTO diem (masv, mamon, diem1, diem2, diemthi, diemtbm) VALUES ('$masv', '$mamon', '$diem1', '$diem2', '$diemthi', '$diemtbm')";
            $conn->query($sqlInsertDiem);
        }

        // Chuyển hướng về trang chủ hoặc trang danh sách sinh viên và điểm
        header("Location: index.php");
        exit();
    }
} else {
    echo "Thiếu thông tin sinh viên và môn học.";
}

// Đóng kết nối CSDL
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Điểm Sinh Viên</title>
</head>
<body>
    <div class='container mt-4'>
    <h2>Sửa Điểm Sinh Viên</h2>
    <form method="post" action="">
    <div class="form-group">
        <label for="diem1">Điểm 1:</label>
        <input type="text" class="form-control" name="diem1" value="<?php echo $diem1; ?>"><br>

        <label for="diem2">Điểm 2:</label>
        <input type="text" class="form-control" name="diem2" value="<?php echo $diem2; ?>"><br>

        <label for="diemthi">Điểm Thi:</label>
        <input type="text" class="form-control" name="diemthi" value="<?php echo $diemthi; ?>"><br>

        <label for="diemtbm">Điểm TB Môn:</label>
        <input type="text" class="form-control" name="diemtbm" value="<?php echo $diemtbm; ?>" readonly><br>

        <input type="submit" value="Lưu">
    </form>
</body>
</html>
