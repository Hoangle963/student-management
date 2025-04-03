<!DOCTYPE html>
<html lang="vi">
<?php include "menu.php"; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Thông Tin Đào Tạo</title>
</head>
<body>
    <br><br><br>
    <div class="container mt-4">
    <h2>Xem Thông Tin Đào Tạo</h2>
    <?php
require_once("connection.php");

// Thực hiện truy vấn để lấy thông tin từ bảng daotao
$sql = "SELECT dt.ma_dt, dt.magv, dt.malop, dt.mamon, dt.namhoc, dt.hocki,
               l.tenlop, gv.hoten, m.tenmon
        FROM daotao dt
        LEFT JOIN lop l ON dt.malop = l.malop
        LEFT JOIN giang_vien gv ON dt.magv = gv.magv
        LEFT JOIN monhoc m ON dt.mamon = m.mamon";

$result = $conn->query($sql);

// Kiểm tra lỗi kết nối
if (!$result) {
    die("Lỗi kết nối hoặc câu truy vấn: " . $conn->error);
}

// Hiển thị thông tin trong bảng
if ($result->num_rows > 0) {
    echo "
   
    <table class='table table-bordered'>
            <tr>
                <th>Mã Đào Tạo</th>
                <th>Mã Giáo Viên</th>
                <th>Mã Lớp</th>
                <th>Mã Môn</th>
                <th>Năm Học</th>
                <th>Học Kì</th>
                <th>Tên Lớp</th>
                <th>Tên Giáo Viên</th>
                <th>Tên Môn</th>
                <!--Thêm các cột khác từ bảng daotao-->
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["ma_dt"] . "</td>
                <td>" . $row["magv"] . "</td>
                <td>" . $row["malop"] . "</td>
                <td>" . $row["mamon"] . "</td>
                <td>" . $row["namhoc"] . "</td>
                <td>" . $row["hocki"] . "</td>
                <td>" . $row["tenlop"] . "</td>
                <td>" . $row["hoten"] . "</td>
                <td>" . $row["tenmon"] . "</td>
                <!--Thêm các cột khác từ bảng daotao-->
            </tr>";
    }

    echo "</table>";
} else {
    echo "Không có dữ liệu trong bảng daotao.";
}

// Đóng kết nối
$conn->close();
?>


</body>
</html>
