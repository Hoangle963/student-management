<?php
// connection.php
require_once("connection.php");
// Kiểm tra xem form đã được submit chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $hoten = $_POST["hoten"];
    $matkhau = $_POST["matkhau"];

    // Thêm thông tin vào bảng admin
    $sql_insert_admin = "INSERT INTO admin (hoten, mat_khau) VALUES ('$hoten', '$matkhau')";
    if ($conn->query($sql_insert_admin) === TRUE) {
        // Lấy id_admin mới được thêm
        $id_admin = $conn->insert_id;

        // Thêm thông tin vào bảng user
        $sql_insert_user = "INSERT INTO user (taikhoan, mat_khau, chucvu) VALUES ('$id_admin', '$matkhau', 'admin')";
        if ($conn->query($sql_insert_user) === TRUE) {
            echo "Thêm thông tin thành công!";
        } else {
            echo "Lỗi thêm thông tin vào bảng user: " . $conn->error;
        }
    } else {
        echo "Lỗi thêm thông tin vào bảng admin: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thông tin Admin</title>
</head>
<body>

<h2>Thêm thông tin Admin</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="hoten">Họ tên:</label>
    <input type="text" name="hoten" required>

    <br>

    <label for="matkhau">Mật khẩu:</label>
    <input type="password" name="matkhau" required>

    <br>

    <input type="submit" value="Thêm thông tin">
</form>

</body>
</html>
