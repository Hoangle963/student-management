<?php
// get_class_list.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị nganhhoc và khoahoc từ POST
    $nganhhoc = $_POST['nganhhoc'];
    $khoahoc = $_POST['khoahoc'];

    // Thực hiện truy vấn để lấy danh sách lớp từ cơ sở dữ liệu
    require_once("connection.php");
    $sql = "SELECT malop, tenlop FROM lop WHERE ma_nh = '$nganhhoc' AND id_khoa = '$khoahoc'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<label for='malop'>Mã Lớp:</label>";
        echo "<select class='form-control' name='malop' required>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["malop"] . "'>" . $row["tenlop"] . "</option>";
        }
        echo "</select>";
    } else {
        echo "Không có lớp nào.";
    }

    $conn->close();
}
?>
