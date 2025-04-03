<!DOCTYPE html>
<html>
<head>
    <title>Bảng Điều Khiển</title>
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            display: flex;
            justify-content: space-around; /* Canh giữa các block */
            flex-wrap: wrap; /* Cho phép các block xuống dòng */
            max-width: 1200px; /* Giới hạn chiều rộng tối đa của container */
            margin: 50px auto; /* Canh giữa container trên trang */
        }
        .block {
            flex: 0 0 20%; /* Đặt chiều rộng của mỗi block */
            padding: 20px;
            margin: 10px;
            border: 1px solid #ced4da;
            background-color: #fff;
            text-align: center;
            color: #212529;
            border-radius: 15px;
            text-decoration: none;
            transition: transform 0.3s ease-in-out;
        }
        .block:hover {
            transform: scale(1.05); /* Thêm hiệu ứng thu/phóng khi di chuột vào */
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
<div>
    <h1>Danh Sách Thống Kê</h1>
    
    <div class="container">
        <a href="display_sinhvien" class="block">
            <h5>Số sinh viên</h5>
            <p>
                <?php
                require_once("connection.php");

                $result = $conn->query("SELECT COUNT(*) as count FROM sinh_vien");
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row["count"];
                } else {
                    echo "0";
                }
                ?>
            </p>
        </a>
        <a href="display_lop" class="block">
            <h5>Số lớp</h5>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM lop");
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row["count"];
                } else {
                    echo "0";
                }
                ?>
            </p>
        </a>
        <a href="display_giangvien" class="block">
            <h5>Số Giảng viên</h5>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM giang_vien");
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row["count"];
                } else {
                    echo "0";
                }
                ?>
            </p>
        </a>
        <a href="display_monhoc" class="block">
            <h5>Số môn học</h5>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) as count FROM monhoc");
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row["count"];
                } else {
                    echo "0";
                }
                $conn->close();
                ?>
            </p>
        </a>
    </div>
</div>
</body>
</html>
