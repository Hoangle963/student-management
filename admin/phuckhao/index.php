<?php include "menu.php"; ?><br><br><br>
<?php

// Perform a database query to get all records
require_once("connection.php");

// Query the phuc_khao table for all records
$sql = "SELECT ma_pk, masv, mamon, trang_thai FROM phuc_khao";
$result = mysqli_query($conn, $sql);

// Fetch all records
$phuc_khao_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

// HTML part starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phúc Khảo List</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <?php if (!empty($phuc_khao_list)): ?>
        <h1>Phúc Khảo List</h1>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Mã Phúc Khảo</th>
                    <th scope="col">Mã Sinh Viên</th>
                    <th scope="col">Mã Môn</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Edit Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($phuc_khao_list as $phuc_khao_data): ?>
                    <tr>
                        <td><?php echo $phuc_khao_data['ma_pk']; ?></td>
                        <td><?php echo $phuc_khao_data['masv']; ?></td>
                        <td><?php echo $phuc_khao_data['mamon']; ?></td>
                        <td><?php echo $phuc_khao_data['trang_thai']; ?></td>
                        <td>
                            <!-- Edit Score Button with URL parameters -->
                            <a href="edit_diem.php?masv=<?php echo $phuc_khao_data['masv']; ?>&mamon=<?php echo $phuc_khao_data['mamon']; ?>" class="btn btn-primary">Sửa điểm</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>No Phúc Khảo records found.</p>
    <?php endif; ?>
</div>

<!-- Add Bootstrap JS and Popper.js scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
