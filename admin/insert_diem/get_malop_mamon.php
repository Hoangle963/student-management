<?php
// get_malop_mamon.php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masv = $_POST["masv"];

    // Lấy malop từ bảng sinh_vien
    $sql_malop = "SELECT malop FROM sinh_vien WHERE masv = '$masv'";
    $result_malop = $conn->query($sql_malop);

    if ($result_malop->num_rows > 0) {
        $row_malop = $result_malop->fetch_assoc();
        $malop = $row_malop["malop"];

        // Lấy danh sách Mã môn và Tên môn từ bảng daotao và monhoc
        $sql_mamon = "SELECT DISTINCT daotao.mamon, monhoc.tenmon FROM daotao
                      JOIN monhoc ON daotao.mamon = monhoc.MaMon
                      WHERE malop = '$malop'";
        $result_mamon = $conn->query($sql_mamon);

        if ($result_mamon->num_rows > 0) {
            $options = "<option value=''>Chọn Môn Học</option>";
            while ($row_mamon = $result_mamon->fetch_assoc()) {
                $options .= "<option value='" . $row_mamon["mamon"] . "'>" . $row_mamon["mamon"] . " - " . $row_mamon["tenmon"] . "</option>";
            }
            echo $options;
        } else {
            echo "<option value=''>Không có Môn Học</option>";
        }
    } else {
        echo "Không tìm thấy malop cho sinh viên.";
    }
} else {
    echo "Phương thức không được hỗ trợ.";
}

$conn->close();
?>
