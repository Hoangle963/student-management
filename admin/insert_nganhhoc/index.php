<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Ngành Học</title>
</head>
<body>
    <h1>Thêm Ngành Học</h1>
    <form action="process.php" method="post">
        <label for="ten_nganh">Tên ngành:</label>
        <input type="text" name="ten_nganh" required>
        <br>
        <label for="kihieu">Kí hiệu:</label>
        <input type="text" name="kihieu" required>
        <br>
        <input type="submit" value="Thêm Ngành Học">
    </form>
</body>
</html>
