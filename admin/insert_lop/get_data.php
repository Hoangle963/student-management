<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Khởi đầu session
session_start();

if ($_GET["type"] == "ma_nh") {
    // Truy vấn để lấy dữ liệu từ bảng nganh_hoc
    $sql_nganh = "SELECT ma_nh, ten_nganh FROM nganh_hoc";
    $result_nganh = $conn->query($sql_nganh);

    // Lưu thông tin vào session
    $_SESSION["ma_nh_data"] = array();
    if ($result_nganh->num_rows > 0) {
        while ($row_nganh = $result_nganh->fetch_assoc()) {
            $_SESSION["ma_nh_data"][$row_nganh["ma_nh"]] = $row_nganh["ten_nganh"];
            echo "<option value='" . $row_nganh["ma_nh"] . "'>" . $row_nganh["ten_nganh"] . "</option>";
        }
    }
} elseif ($_GET["type"] == "id_khoa") {
    // Truy vấn để lấy dữ liệu từ bảng khoa_hoc
    $sql_khoa = "SELECT id_khoa, namhoc FROM khoa_hoc";
    $result_khoa = $conn->query($sql_khoa);

    // Lưu thông tin vào session
    $_SESSION["id_khoa_data"] = array();
    if ($result_khoa->num_rows > 0) {
        while ($row_khoa = $result_khoa->fetch_assoc()) {
            $_SESSION["id_khoa_data"][$row_khoa["id_khoa"]] = $row_khoa["namhoc"];
            echo "<option value='" . $row_khoa["id_khoa"] . "'>" . $row_khoa["namhoc"] . "</option>";
        }
    }
} else {
    echo "Loại dữ liệu không hợp lệ.";
}

// Đóng kết nối
$conn->close();
?>
