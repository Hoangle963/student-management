<?php
session_start();
 include "menu.php"; ?>
<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Lấy thông tin từ request
$masv = $_GET['masv'];
$mamon = $_GET['mamon'];

// Truy vấn CSDL để lấy thông tin điểm của sinh viên cho môn học đã chọn
$query = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
$result = $conn->query($query);

// Đảm bảo rằng có dữ liệu để hiển thị
if ($result->num_rows > 0) {
    // Lấy thông tin điểm từ kết quả truy vấn
    $row = $result->fetch_assoc();
    
    // Hiển thị form sửa điểm
    echo "
    <div class='container mt-5'>
    <h2>Sửa Điểm</h2>";
    echo "<form action='update_grade.php' method='post'>";
    echo "
    <div class='form-group'>
    <input type='hidden' name='masv' value='$masv'>";
    echo "<input type='hidden' name='mamon' value='$mamon'>";
    echo "Điểm 1: <input type='text'  class='form-control' name='diem1' value='" . $row['diem1'] . "'><br>";
    echo "Điểm 2: <input type='text'  class='form-control' name='diem2' value='" . $row['diem2'] . "'><br>";
    echo "Điểm Thi: <input type='text'  class='form-control' name='diemthi' value='" . $row['diemthi'] . "'><br>";
    echo "<button class='btn btn-info' type='submit'>Cập Nhật Điểm</button>";
    echo "</form>";
} else {
    // Nếu không có điểm, hiển thị form để thêm điểm (đã giữ nguyên form thêm điểm ở trên)
    
    echo "<div class='container mt-5'><h2>Thêm Điểm</h2>";
    echo "<form action='add_grade.php' method='post'>";
    echo "<div class='form-group'><input type='hidden' name='masv' value='$masv'>";
    echo "<input type='hidden' name='mamon' value='$mamon'>";
    echo "Điểm 1: <input type='text' class='form-control' name='diem1'><br>";
    echo "Điểm 2: <input type='text' class='form-control' name='diem2'><br>";
    echo "Điểm Thi: <input type='text' class='form-control' name='diemthi'><br>";
    echo "<button class='btn btn-info' type='submit'>Thêm Điểm</button>";
    echo "</form>";
}

// Đóng kết nối CSDL
$conn->close();
?>
