<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>測驗1</title>
</head>
<body>
    <h1>我的練習 php & mysq1</h1>

    <p>今天是: <?=date("Y年m月d日") ?></p>
    <hr>
    <p>我的名字: <?= $_GET["name"] ?></p>
    <p>我的年紀: <?= $_GET["age"] ?></p>

    <p>我的身高: <?= $h=$_GET["height"] ?></p>
    <p>我的體重: <?= $w=$_GET["weight"] ?></p>
    <p>我的bmi值: <?= $w/($h/100*$h/100) ?></p>
    </body>
</html>