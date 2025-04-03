<!-- ThemDiem.php -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Điểm</title>
    <?php include "menu.php"; ?>
    <br><br><br>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Hàm kiểm tra việc chọn sinh viên và môn học
            function checkSelections() {
                var masv = $('#masv').val();
                // Kiểm tra nếu sinh viên đã được chọn
                if (masv) {
                    // Gửi Ajax để lấy malop của sinh viên
                    $.ajax({
                        url: "get_malop.php", // Đường dẫn tới file xử lý
                        method: "POST",
                        data: {
                            masv: masv
                        },
                        success: function (data) {
                            var malop = data.trim(); // Nhận giá trị malop

                            // Gửi Ajax để lấy danh sách MaMon từ malop
                            $.ajax({
                                url: "get_mamon.php", // Đường dẫn tới file xử lý
                                method: "POST",
                                data: {
                                    malop: malop
                                },
                                success: function (data) {
                                    // Cập nhật dropdown MaMon với danh sách MaMon mới
                                    $('#MaMon').html(data);
                                    // Xóa bảng điểm nếu không đủ điều kiện
                                    $('#bang_diem').html('');
                                }
                            });
                        }
                    });
                }
            }

            // Gắn sự kiện change chỉ cho dropdown sinh viên
            $('#masv').change(checkSelections);
        });
    </script>
</head>

<body>
    <div >
    <div class="container mt-5">
        <h2>Thêm Điểm</h2>
        <div>
            <form action="them_diem_check.php" method="POST">
            
                Sinh viên:
                <select class="form-control" name="masv" id="masv">
                    <option  value="">Chọn Sinh Viên</option>
                    <?php
                    require_once("connection.php");
                    $sql = "SELECT masv, hoten FROM sinh_vien";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["masv"] . "'>" . $row["hoten"] . " - " . $row["masv"] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                Môn Học:
                <select class="form-control" name="MaMon" id="MaMon">
                    <option class="form-control" value="">Chọn Môn Học</option>
                    <!-- Option sẽ được cập nhật bằng Ajax -->
                </select>
            </div>

            <input class='btn btn-info' type="submit" value="Chọn">
        </form>

        <!-- Phần để hiển thị bảng điểm sau khi chọn sinh viên và môn học -->
        <div id="bang_diem">
        </div>
    </div>
</body>

</html>
