<?php
// Bật chế độ báo cáo lỗi trong quá trình phát triển
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Hàm làm sạch dữ liệu để tránh các tấn công XSS
function cleanData($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Không cần kiểm tra selectedClass vì bạn muốn xuất tất cả giảng viên

require_once("connection.php");

$sql_giangvien = "SELECT * FROM giang_vien";
$result_giangvien = $conn->query($sql_giangvien);

if ($result_giangvien->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Tiêu đề danh sách giảng viên
    $sheet->setCellValue('A1', 'Danh sách giảng viên');
    $sheet->mergeCells('A1:E1'); // Gộp ô cho tiêu đề
    $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

    // Tiêu đề cột
    $sheet->setCellValue('A2', 'Mã Giảng Viên');
    $sheet->setCellValue('B2', 'Họ Tên');
    $sheet->setCellValue('C2', 'Giới Tính');
    $sheet->setCellValue('D2', 'Ngày Sinh');
    $sheet->setCellValue('E2', 'Email');

    // Đặt độ dài cho các cột
    $sheet->getColumnDimension('A')->setWidth(20);
    $sheet->getColumnDimension('B')->setWidth(40);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(30);

    // Dữ liệu
    $row = 3;
    while ($row_giangvien = $result_giangvien->fetch_assoc()) {
        $data = [
            cleanData($row_giangvien["magv"]),
            cleanData($row_giangvien["hoten"]),
            cleanData($row_giangvien["gioitinh"]),
            cleanData($row_giangvien["ngaysinh"]),
            cleanData($row_giangvien["email"])
        ];
        $sheet->fromArray([$data], NULL, 'A' . $row);
        $row++;
    }

    // Xuất Excel
    $filename = "DanhSachGiangVien_TatCa.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
} else {
    // Xử lý khi không có giảng viên
    echo "Không có giảng viên nào.";
}

$conn->close();
?>
