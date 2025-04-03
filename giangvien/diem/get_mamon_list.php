
<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Bắt đầu session
session_start();

// Lấy thông tin từ session
$magv = $_SESSION['taikhoan'];

// Kiểm tra xem có tham số masv được truyền qua không
if (isset($_GET['masv'])) {
    $selectedStudent = $_GET['masv'];

    // Truy vấn CSDL để lấy malop của sinh viên được chọn
    $malopQuery = "SELECT malop FROM sinh_vien WHERE masv = '$selectedStudent'";
    $malopResult = $conn->query($malopQuery);

    if ($malopResult->num_rows > 0) {
        $row = $malopResult->fetch_assoc();
        $malop = $row['malop'];

        // Truy vấn CSDL để lấy danh sách mamon từ daotao dựa trên magv và malop
        $mamonQuery = "SELECT DISTINCT dt.mamon, mh.tenmon
                       FROM daotao dt
                       JOIN monhoc mh ON dt.mamon = mh.mamon
                       WHERE dt.magv = '$magv' AND dt.malop = '$malop'";
        $mamonResult = $conn->query($mamonQuery);

        // Lưu danh sách mamon vào một mảng
        $mamonList = array();
        while ($mamonRow = $mamonResult->fetch_assoc()) {
            $mamonList[] = $mamonRow;
        }

        // Đóng kết nối CSDL
        $conn->close();

        // Trả về danh sách mamon dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($mamonList);
        exit();
    }
}
?>
