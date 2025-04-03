<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập File Excel</title>
    <?php include "menu.php"; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        #uploadResult {
            margin-top: 10px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <br><br><br>
        <h1 class="mb-4">Nhập File Excel</h1>

        <!-- Form nhập file Excel -->
        <form action="import_sinhvien.php" method="post" enctype="multipart/form-data">
       
        Nhập ds bằng excel:<br> <input type="file" name="excel_file" accept=".xlsx">
        <input type="submit" class="btn btn-primary" value="Tải lên">
          
        </form>

        <!-- Thêm một div để hiển thị thông báo -->
        <div id="uploadResult">
            <?php
            // Kiểm tra có thông báo nào không và hiển thị nó
            if (isset($_SESSION['upload_message'])) {
                echo '<div class="alert alert-info mt-3" role="alert">' . $_SESSION['upload_message'] . '</div>';
                unset($_SESSION['upload_message']); // Xóa thông báo sau khi hiển thị
            }
            ?>
        </div>
    </div>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <span class="text-muted">Báo cáo tốt nghiệp sinh viên trường đại học Tài Nguyên và Môi Trường Hà Nội.</span>
        </div>
    </footer>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
