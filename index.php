<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Обработка XLSX-файлов</title>
</head>
<body>
    <form enctype="multipart/form-data">
        <div id="form-title">Загрузите xlsx-файл</div>
        <div id="form-file"><input type="file" name="form-file"></div><br>
        <div id="form-button"><input type="submit" value="Отправить"></div>
    </form>
    <div id="calculated-table"></div>
    <script src="libs/jquery-3.4.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>