
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 50px;
    }

    .card {
        margin-bottom: 20px;
    }
</style>
<?php
session_start();
include "connection.php";
include "menu.php";
if (isset($_SESSION['taikhoan'])) {
    $masv = $_SESSION['taikhoan'];

    $queryMalop = "SELECT malop FROM sinh_vien WHERE masv = '$masv'";
    $resultMalop = $conn->query($queryMalop);

    if ($resultMalop->num_rows > 0) {
        $rowMalop = $resultMalop->fetch_assoc();
        $malop = $rowMalop['malop'];

        $queryDaotao = "SELECT mamon, namhoc, hocki FROM daotao WHERE malop = '$malop'";
        $resultDaotao = $conn->query($queryDaotao);

        if ($resultDaotao->num_rows > 0) {
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Danh Sách Môn Học</title>
                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            </head>

            <body>
                <div class="container mt-5">
                    <h2>Danh Sách Môn Học</h2>
                    <div class="card-deck mt-3 d-flex flex-wrap">
                        <?php
                        $count = 0; // Counter for cards in each row
                        while ($rowDaotao = $resultDaotao->fetch_assoc()) {
                            $mamon = $rowDaotao['mamon'];
                            $namhoc = $rowDaotao['namhoc'];
                            $hocki = $rowDaotao['hocki'];

                            $queryMonhoc = "SELECT tenmon FROM monhoc WHERE mamon = '$mamon'";
                            $resultMonhoc = $conn->query($queryMonhoc);

                            if ($resultMonhoc->num_rows > 0) {
                                $rowMonhoc = $resultMonhoc->fetch_assoc();
                                $tenmon = $rowMonhoc['tenmon'];

                                if ($count % 4 == 0) {
                                    // Start a new row after every 4 cards
                                    echo "</div><div class='card-deck mt-3 d-flex flex-wrap'>";
                                }

                                // Card
                                echo "<div class='card mb-3'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>$tenmon</h5>";
                                echo "<p class='card-text'>Năm học: $namhoc, Học kì: $hocki</p>";
                                echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal$mamon'>Hiển thị Điểm</button>";
                                echo "</div>";
                                echo "</div>";

                                // Modal
                                echo "<div class='modal' id='myModal$mamon'>";
                                echo "<div class='modal-dialog'>";
                                echo "<div class='modal-content'>";
                                echo "<div class='modal-header'>";
                                echo "<h4 class='modal-title'>$tenmon - Năm học: $namhoc, Học kì: $hocki</h4>";
                                echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
                                echo "</div>";
                                echo "<div class='modal-body'>";
                                
                                // Truy vấn để lấy thông tin điểm từ bảng diem
                                $queryDiem = "SELECT * FROM diem WHERE masv = '$masv' AND mamon = '$mamon'";
                                $resultDiem = $conn->query($queryDiem);

                                if ($resultDiem->num_rows > 0) {
                                    // Hiển thị thông tin điểm
                                    echo "<table class='table'>";
                                    echo "<thead><tr><th>Điểm 1</th><th>Điểm 2</th><th>Điểm Thi</th><th>Điểm TB Môn</th></tr></thead>";
                                    echo "<tbody>";
                                    while ($rowDiem = $resultDiem->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $rowDiem['diem1'] . "</td>";
                                        echo "<td>" . $rowDiem['diem2'] . "</td>";
                                        echo "<td>" . $rowDiem['diemthi'] . "</td>";
                                        echo "<td>" . $rowDiem['diemtbm'] . "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "Không có thông tin điểm.";
                                }

                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                        
                    

                                $count++;
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Bootstrap JS và jQuery (đặt ở cuối trang để tối ưu hiệu suất) -->
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            </body>

            </html>
        <?php
        } else {
            echo "Không có môn học nào.";
        }
    } else {
        echo "Không tìm thấy thông tin sinh viên.";
    }
} else {
    echo "Bạn chưa đăng nhập.";
}

$conn->close();
?>
