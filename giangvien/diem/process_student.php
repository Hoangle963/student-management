<?php include "menu.php"; ?>
<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Bắt đầu session
session_start();

// Lấy thông tin từ session
$magv = $_SESSION['taikhoan'];

// Kiểm tra xem nút submit đã được nhấn chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị được chọn từ form
    $selectedStudent = $_POST['sinhVien'];

    // Truy vấn CSDL để lấy malop của sinh viên được chọn
    $malopQuery = "SELECT malop FROM sinh_vien WHERE masv = '$selectedStudent'";
    $malopResult = $conn->query($malopQuery);

    if ($malopResult->num_rows > 0) {
        $row = $malopResult->fetch_assoc();
        $malop = $row['malop'];

        // Truy vấn CSDL để lấy danh sách mamon từ daotao dựa trên magv và malop
        $mamonQuery = "SELECT DISTINCT mamon FROM daotao WHERE magv = '$magv' AND malop = '$malop'";
        $mamonResult = $conn->query($mamonQuery);

        // Lưu danh sách mamon vào một mảng
        $mamonList = array();
        while ($mamonRow = $mamonResult->fetch_assoc()) {
            $mamonList[] = $mamonRow['mamon'];
        }

        // Đóng kết nối CSDL
        $conn->close();

        // Hiển thị danh sách mamon trong form
        echo "<label for='mamon'>Chọn Môn Học:</label>
              <select name='mamon' id='mamon'>";
        foreach ($mamonList as $mamon) {
            echo "<option value='$mamon'>$mamon</option>";
        }
        echo "</select>
              <input type='submit' value='Xem Thông Tin Môn Học'>";
    } else {
        echo "Không tìm thấy malop cho sinh viên đã chọn.";
    }
}
?>
