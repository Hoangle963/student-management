<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['excel_file']['name']) && $_FILES['excel_file']['error'] == 0) {
        $file_name = $_FILES['excel_file']['name'];
        $file_tmp = $_FILES['excel_file']['tmp_name'];

        // Kiểm tra định dạng tệp Excel (.xlsx)
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if ($file_ext != 'xlsx') {
            echo "Chỉ chấp nhận tệp Excel (.xlsx).";
        } else {
            // Xử lý dữ liệu từ tệp Excel và thêm vào CSDL
            $spreadsheet = IOFactory::load($file_tmp);
            $worksheet = $spreadsheet->getActiveSheet();

            // Kết nối đến CSDL
            require_once("connection.php");

            $row_number = 0;
            $sinhvien_added = false; // Biến kiểm soát

            foreach ($worksheet->getRowIterator() as $row) {
                $cell_iterator = $row->getCellIterator();
                $cell_iterator->setIterateOnlyExistingCells(FALSE);

                $data = [];
                foreach ($cell_iterator as $cell) {
                    $data[] = $cell->getValue();
                }

                // Bỏ qua dòng đầu tiên (dòng tiêu đề)
                if ($row_number == 0) {
                    $row_number++;
                    continue;
                }

                // Lấy ma_nh từ ten_nganh
                $ten_nganh = $data[5];
                $ma_nh_query = "SELECT ma_nh FROM nganh_hoc WHERE ten_nganh = '$ten_nganh'";
                $ma_nh_result = $conn->query($ma_nh_query);

                if ($ma_nh_result->num_rows > 0) {
                    $ma_nh_row = $ma_nh_result->fetch_assoc();
                    $ma_nh = $ma_nh_row['ma_nh'];

                    // Lấy id_khoa từ ma_nh và namhoc
                    $namhoc = $data[6];
                    $id_khoa_query = "SELECT id_khoa FROM khoa_hoc WHERE namhoc = '$namhoc'";
                    $id_khoa_result = $conn->query($id_khoa_query);

                    if ($id_khoa_result->num_rows > 0) {
                        $id_khoa_row = $id_khoa_result->fetch_assoc();
                        $id_khoa = $id_khoa_row['id_khoa'];

                        // Lấy danh sách malop từ ma_nh và id_khoa
                        $malop_query = "SELECT malop FROM lop WHERE ma_nh = '$ma_nh' AND id_khoa = '$id_khoa'";
                        $malop_result = $conn->query($malop_query);

                        if ($malop_result->num_rows > 0) {
                            $classes = [];
                            while ($class_row = $malop_result->fetch_assoc()) {
                                $classes[] = $class_row['malop'];
                            }

                            // Chọn một lớp ngẫu nhiên từ danh sách
                            $malop = $classes[array_rand($classes)];

                            // Thêm dữ liệu `hoten`, `gioitinh`, `Ngaysinh`, `ma_nh`, `id_khoa`, `malop` vào CSDL
                            $sql_insert_sinhvien = "INSERT INTO sinh_vien (hoten, gioitinh, Ngaysinh, email, ma_nh, id_khoa, malop) VALUES (?, ?, ?, ?, ?, ?, ?)";
                            $stmt_insert_sinhvien = $conn->prepare($sql_insert_sinhvien);

                            if (!$stmt_insert_sinhvien) {
                                die('Lỗi trong quá trình chuẩn bị: ' . $conn->error);
                            }

                            // Lấy mã sinh viên (masv) của sinh viên vừa được thêm
                            $masv = $conn->insert_id;

                            $stmt_insert_sinhvien->bind_param("sssssss", $data[1], $data[2], $data[3], $data[4], $ma_nh, $id_khoa, $malop);

                            if ($stmt_insert_sinhvien->execute()) {
                                // Nếu thêm sinh viên thành công, đặt biến kiểm soát thành true
                                $sinhvien_added = true;

                                // Thêm thông tin tài khoản vào bảng user
                                $sql_insert_user = "INSERT INTO user (taikhoan, mat_khau, chucvu) VALUES ('$masv', '$masv', 'sinhvien')";
                                if ($conn->query($sql_insert_user) !== TRUE) {
                                    echo "Lỗi khi thêm tài khoản: " . $conn->error;
                                }
                            } else {
                                echo 'Lỗi khi thêm sinh viên: ' . $stmt_insert_sinhvien->error;
                            }

                            $stmt_insert_sinhvien->close();
                        } else {
                            echo "";
                        }
                    } else {
                        echo "Lỗi: Không tìm thấy khoa cho ngành học và năm học.";
                    }
                } else {
                    echo "Lỗi: Không tìm thấy mã ngành học cho tên ngành.";
                }

                // ...
                $row_number++;
            }

            // Đóng kết nối sau khi thêm dữ liệu
            $conn->close();

            if ($sinhvien_added) {
                echo "<script>alert('Thêm dữ liệu thành công.');</script>";
            echo "<script>window.location = '/qlsv/admin/display_sinhvien';</script>";
            } else {
                echo "Không có sinh viên nào được thêm vào CSDL.";
            }
        }
    } else {
        echo "Vui lòng chọn tệp Excel để tải lên.";
    }
} else {
    // Nếu truy cập trang trực tiếp mà không thông qua biểu mẫu
    header("Location: your_form_page.php");
    exit();
}
?>
