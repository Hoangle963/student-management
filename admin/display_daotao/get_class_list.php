<?php
// get_class_list.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị malop và mamon từ POST
    $malop = $_POST['malop'];
    $mamon = $_POST['mamon'];

    // Thực hiện truy vấn để lấy danh sách sinh viên từ bảng daotao
    require_once("connection.php");
    $sql = "SELECT sinh_vien.masv, sinh_vien.hoten FROM sinh_vien INNER JOIN daotao ON sinh_vien.malop = daotao.malop AND daotao.mamon = '$mamon' WHERE sinh_vien.malop = '$malop'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<label for='masv'>Mã Sinh Viên:</label>";
        echo "<select name='masv' required>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["masv"] . "'>" . $row["hoten"] . "</option>";
        }
        echo "</select>";
    } else {
        echo "Không có sinh viên nào.";
    }

    $conn->close();
}
?>
