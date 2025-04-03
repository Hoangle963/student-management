<?php
// get_mamon.php
require_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $malop = $_POST["malop"];

    $sql_mamon = "SELECT DISTINCT d.mamon, m.tenmon 
                  FROM daotao d 
                  JOIN monhoc m ON d.mamon = m.mamon
                  WHERE d.malop = '$malop'";
                  
    $result_mamon = $conn->query($sql_mamon);

    if ($result_mamon->num_rows > 0) {
        while ($row_mamon = $result_mamon->fetch_assoc()) {
            echo "<option value='" . $row_mamon["mamon"] . "'>" . $row_mamon["tenmon"]." -" . $row_mamon["mamon"]. "</option>";
        }
    } else {
        echo "<option value=''>Không có Môn Học</option>";
    }
} else {
    echo "Phương thức không được hỗ trợ.";
}

$conn->close();
?>
