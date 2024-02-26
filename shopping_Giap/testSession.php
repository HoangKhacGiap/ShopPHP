<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test session</title>
</head>
<body>
    <?php
        session_start();
        var_dump($_SESSION);
        session_destroy();
    ?>
</body>
</html>