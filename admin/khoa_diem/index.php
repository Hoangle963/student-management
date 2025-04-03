<?php include 'Connection.php'; ?>
<?php include "menu.php"; ?><br><br><br><div class="container mt-4">
<?php


// Truy vấn để lấy danh sách năm học, học kì 
$sql = "SELECT DISTINCT namhoc, hocki FROM daotao";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>";
    echo "<tr><th>Năm học</th><th>Học kì</th><th>Hoạt động</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>
            {$row['namhoc']}
            </td>
            <td>
            {$row['hocki']}
            </td>
            <td><a class='btn btn-primary' href='update.php?namhoc={$row['namhoc']}&hocki={$row['hocki']}'>Lock Điểm</a></td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

// Đóng kết nối CSDL
$conn->close();

?>