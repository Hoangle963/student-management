<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    require_once("connection.php");

    // Lấy giá trị ma_nh và id_khoa từ POST
    $ma_nh = $_POST['ma_nh'];
    $id_khoa = $_POST['id_khoa'];

    // Thực hiện truy vấn để lấy kí hiệu từ cơ sở dữ liệu
    $sql = "SELECT nganh_hoc.kihieu_n, khoa_hoc.kihieu_k 
            FROM nganh_hoc 
            JOIN khoa_hoc ON nganh_hoc.ma_nh = '$ma_nh' AND khoa_hoc.id_khoa = '$id_khoa'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kihieu_n = $row['kihieu_n'];
        $kihieu_k = $row['kihieu_k'];

        // Trả kết quả dưới dạng JSON về client
        echo json_encode(['kihieu_n' => $kihieu_n, 'kihieu_k' => $kihieu_k]);
    } else {
        echo "Không tìm thấy dữ liệu.";
    }

    $conn->close();
}
?>
