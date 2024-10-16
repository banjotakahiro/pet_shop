<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';

// データベースに接続
$dbh = connect_db();

// SQL文の組み立て
$sql = 'SELECT * FROM animals';

// プリペアドステートメントの準備
// $dbh->query($sql) でも良い
$stmt = $dbh->prepare($sql);

// プリペアドステートメントの実行
$stmt->execute();

// 結果の取得
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO - SELECT</title>
</head>
<body>
    <h2>データの抽出成功</h2>
    <ul>
        <?php foreach ($animals as $animal): ?>
            <li><?= h($animal['type']) . 'の' . h($animal['classification']) . 'ちゃん' ?></li>
            <li style="list-style-type: none;"><?= h($animal['description']) ?></li>
            <li style="list-style-type: none;"><?= h($animal['birthday']) . '生まれ' ?></li>
            <li style="list-style-type: none;"><?= '出身地：' . h($animal['birthplace'])  ?></li>
            <hr color="gray" size="2">
        <?php endforeach; ?>
    </ul>
</body>
</html>

