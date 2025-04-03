<?php
// Kết nối đến cơ sở dữ liệu
require_once("connection.php");

// Kiểm tra xem form đã được submit chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy tên người dùng và mật khẩu từ form
    $username = $_POST["taikhoan"];
    $password = $_POST["mat_khau"];

    // Truy vấn cơ sở dữ liệu để kiểm tra đăng nhập
    $sql = "SELECT * FROM user WHERE taikhoan = '$username' AND mat_khau = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $row = $result->fetch_assoc();
        $role = $row['chucvu'];

        session_start();
        $_SESSION['taikhoan'] = $username;
        $_SESSION['chucvu'] = $role;
        // Đăng nhập thành công, kiểm tra vai trò và chuyển hướng
        if ($role == "sinhvien") {
            header("Location: sinhvien/"); // Chuyển hướng đến trang cho sinh viên
        } elseif ($role == "giangvien") {
            header("Location: giangvien/"); // Chuyển hướng đến trang cho giảng viên
        } elseif ($role == "admin") {
            header("Location: admin/"); // Chuyển hướng đến trang quản trị
        } else {
            // Nếu có các vai trò khác, xử lý tương ứng
            // header("Location: trang_khac.php");
        }

        exit; // Kết thúc kịch bản để không tiếp tục thực thi code
    } else {
        // Đăng nhập không thành công
     
    }
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        form {
            background-color: #fff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: #ff0000;
        }
    </style>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Đăng nhập</h2>

    <label for="taikhoan">Tài khoản:</label>
    <input type="text" name="taikhoan" required>

    <label for="mat_khau">Mật khẩu:</label>
    <input type="password" name="mat_khau" required>

    <br>

    <input type="submit" value="Đăng nhập">

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $result->num_rows == 0) {
        echo '<p class="error">Đăng nhập không thành công. Vui lòng kiểm tra lại tài khoản và mật khẩu.</p>';
    }
    ?>

</form>

</body>
</html>
