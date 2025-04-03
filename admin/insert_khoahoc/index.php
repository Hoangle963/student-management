<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khóa Học</title>
</head>
<body>
    <h1>Thêm Khóa Học</h1>
    <form action="process.php" method="post">
        <label for="namhoc">Năm học:</label>
        <input type="number" name="namhoc" required min="2020" required max="2023" value="2020">
        <br>
        <input type="submit" value="Thêm Khóa Học">
    </form>
</body>
</html>
