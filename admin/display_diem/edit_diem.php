<!-- edit_diem.php -->
<?php include "menu.php"; ?>
<div class="container mt-5"><br><br><br>

<?php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $masv = $_GET["masv"];
    $mamon = $_GET["mamon"];

    // Thực hiện truy vấn để lấy điểm của sinh viên cho môn học cụ thể
    $sql_grade = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
    $result_grade = $conn->query($sql_grade);

    if ($result_grade->num_rows > 0) {
        $row = $result_grade->fetch_assoc();
        $diem1 = $row["diem1"];
        $diem2 = $row["diem2"];
        $diemthi = $row["diemthi"];
        // Các giá trị khác bạn cần lấy từ cơ sở dữ liệu

        // Hiển thị form sửa điểm
        echo "<form action='process_edit_diem.php' method='post'>
        <div class='form-group'>
                <input type='hidden' name='masv' value='$masv'>
                <input type='hidden' name='mamon' value='$mamon'>
                <label for='diem1'>Mã sinh viên:</label>
                <input type='text' class='form-control' name='masv' value='$masv' readonly><br>
                <label for='diem1'>Điểm 1:</label>
                <input type='text' class='form-control' name='diem1' value='$diem1'><br>
                <label for='diem2'>Điểm 2:</label>
                <input type='text' class='form-control' name='diem2' value='$diem2'><br>
                <label for='diemthi'>Điểm Thi:</label>
                <input type='text' class='form-control' name='diemthi' value='$diemthi'><br>
                <!-- Các trường khác bạn cần sửa -->
                <input type='submit' class='btn btn-info' value='Lưu'>
            </form>";
    } else {
        echo "Không tìm thấy thông tin điểm cho sinh viên và môn học này.";
    }
} else {
    echo "Phương thức không được hỗ trợ.";
}

$conn->close();
?>
