<?php
// get_malop.php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masv = $_POST["masv"];

    $sql_malop = "SELECT malop FROM sinh_vien WHERE masv = '$masv'";
    $result_malop = $conn->query($sql_malop);

    if ($result_malop->num_rows > 0) {
        $row_malop = $result_malop->fetch_assoc();
        echo $row_malop["malop"];
    } else {
        echo "Không tìm thấy malop.";
    }
} else {
    echo "Phương thức không được hỗ trợ.";
}

$conn->close();
?>
