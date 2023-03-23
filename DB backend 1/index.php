<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Admin Table</title>

</head>

<body>

    <h1>Admin Table</h1>

    <div class="container">

    <?php

    include_once "back/MySQL_Driver.php";

    $con = new MySQL();
    $con->connect("localhost","root","","letadlo");
    $table = $con->table("SELECT `user`.`id`, `user`.`name`, `user`.`surname`, `flight`.`where`, `flight`.`to` FROM `flight` JOIN `user` ON `flight`.`id` = `user`.`fly_id`;");
    echo $table;
    ?>

    </div>

</body>

</html>