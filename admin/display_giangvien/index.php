<!-- list_giangvien.php -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Giảng Viên</title>
    <?php include "menu.php"; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4"><br><br><br>
        <h2>Danh Sách Giảng Viên</h2>
        <button class="btn btn-success mb-2" onclick="exportToExcel()">Xuất Excel</button>

<table class="table table-bordered">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã Giảng Viên</th>
                    <th>Họ Tên</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Email</th>
                    <th>Chức Năng</th>
                </tr>
            </thead>

            <tbody>
                <?php
                require_once("connection.php");

                $sql = "SELECT * FROM giang_vien";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["magv"] . "</td>";
                        echo "<td>" . $row["hoten"] . "</td>";
                        echo "<td>" . $row["gioitinh"] . "</td>";
                        echo "<td>" . $row["ngaysinh"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>
                                <a class='btn btn-info' href='edit_giangvien.php?id=" . $row["magv"] . "'>Sửa</a>
                                <a class='btn btn-info' href='delete_giangvien.php?id=" . $row["magv"] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
    function exportToExcel() {
        window.location.href = 'export_excel.php';
    }
</script>
</body>

</html>
