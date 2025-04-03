<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Môn Học</title>
    <?php include "menu.php"; ?>
</head>

<body>
<div class="container mt-4"><br><br><br>
    <h2>Danh Sách Môn Học</h2>

    <table class="table table-bordered">
        <tr>
            <th>Mã Môn Học</th>
            <th>Tên Môn Học</th>
            <th>Chức Năng</th>
        </tr>

        <?php
        require_once("connection.php");

        $sql = "SELECT * FROM monhoc";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["mamon"] . "</td>";
                echo "<td>" . $row["tenmon"] . "</td>";
                echo "<td>
                        <a  class='btn btn-info' href='edit_monhoc.php?id=" . $row["mamon"] . "'>Sửa</a>
                        <a  class='btn btn-info' href='delete_monhoc.php?id=" . $row["mamon"] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>

</html>
