<?php
require 'vendor/autoload.php'; // Make sure you have installed the PhpSpreadsheet library.

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Perform a database query to get data for all students
require_once("connection.php");

// Export the entire list of students
$sql = "SELECT masv, hoten, gioitinh, Ngaysinh, email, ma_nh, id_khoa, malop FROM sinh_vien";
$result = mysqli_query($conn, $sql);

// Create a new spreadsheet with PhpSpreadsheet library
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column headers
$sheet->setCellValue('A1', 'Mã Sinh Viên');
$sheet->setCellValue('B1', 'Họ và Tên');
$sheet->setCellValue('C1', 'Giới Tính');
$sheet->setCellValue('D1', 'Ngày Sinh');
$sheet->setCellValue('E1', 'Email');
$sheet->setCellValue('F1', 'Mã Ngành Học');
$sheet->setCellValue('G1', 'ID Khoa');
$sheet->setCellValue('H1', 'Mã Lớp');

// Fill data from the database into the spreadsheet
$rowIndex = 2; // Fix variable name from $row to $rowIndex
while ($student_row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowIndex, $student_row["masv"]);
    $sheet->setCellValue('B' . $rowIndex, $student_row["hoten"]);
    $sheet->setCellValue('C' . $rowIndex, $student_row["gioitinh"]);
    $sheet->setCellValue('D' . $rowIndex, $student_row["Ngaysinh"]);
    $sheet->setCellValue('E' . $rowIndex, $student_row["email"]);
    $sheet->setCellValue('F' . $rowIndex, $student_row["ma_nh"]);
    $sheet->setCellValue('G' . $rowIndex, $student_row["id_khoa"]);
    $sheet->setCellValue('H' . $rowIndex, $student_row["malop"]);
    $rowIndex++;
}

// Set style for header row
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '333333']],
    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
];

$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

// Export the Excel file
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="danh_sach_sinhvien.xlsx"');
$writer->save('php://output');
exit;
?>
