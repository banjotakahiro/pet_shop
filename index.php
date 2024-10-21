<?php

// 関数ファイルを読み込む
require_once __DIR__ . '/functions.php';

// データベースに接続
$dbh = connect_db();

// SQL文の組み立て
// PDOで処理する際には先に変数に%ではさんだものを入れ、LIKEで拾います。
// ※LIKEで拾ってくるワードはフォームで自由に入力してきた文字にしたいので、$keywordを設定します。

$keyword = filter_input(INPUT_GET, 'keyword');
  
$sql = 'SELECT * FROM animals WHERE description LIKE :keyword';
$keyword_param = '%' . $keyword . '%';// %ではさむ
// プリペアドステートメントの準備
// $dbh->query($sql) でも良い
$stmt = $dbh->prepare($sql);

$stmt->bindParam(':keyword', $keyword_param, PDO::PARAM_STR);

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
    <h2>本日のご紹介ペット！</h2>
    <form method="GET" action="">
        <input type="text" name="keyword" placeholder="検索キーワードを入力">
        <button type="submit">検索</button>
    </form>
    <p>
        <?php foreach ($animals as $animal): ?>
            <li><?= h($animal['type']) . 'の' . h($animal['classification']) . 'ちゃん' ?></li>
            <li style="list-style-type: none;"><?= h($animal['description']) ?></li>
            <li style="list-style-type: none;"><?= h($animal['birthday']) . '生まれ' ?></li>
            <li style="list-style-type: none;"><?= '出身地：' . h($animal['birthplace'])  ?></li>
            <hr color="gray" size="2">
        <?php endforeach; ?>
    </p>
</body>
</html>

