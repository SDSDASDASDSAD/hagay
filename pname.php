<?php
// ---------- 資料庫連線 ----------
$pdo = new PDO("mysql:host=localhost;dbname=testdb;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ---------- 分頁設定 ----------
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$start = ($page - 1) * $perPage;

// ---------- 處理新增 ----------
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $stmt = $pdo->prepare("INSERT INTO pname (id, pname, pspec, price, pdate, content) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['id'], $_POST['pname'], $_POST['pspec'], $_POST['price'], $_POST['pdate'], $_POST['content']]);
    header("Location: pname.php");
    exit;
}

// ---------- 處理修改 ----------
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $stmt = $pdo->prepare("UPDATE pname SET pname=?, pspec=?, price=?, pdate=?, content=? WHERE id=?");
    $stmt->execute([$_POST['pname'], $_POST['pspec'], $_POST['price'], $_POST['pdate'], $_POST['content'], $_POST['id']]);
    header("Location: pname.php");
    exit;
}

// ---------- 處理刪除 ----------
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM pname WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: pname.php");
    exit;
}

// ---------- 撈單筆資料 ----------
$single = null;
if (isset($_GET['view']) || isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM pname WHERE id = ?");
    $stmt->execute([$_GET['view'] ?? $_GET['edit']]);
    $single = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ---------- 撈所有資料（分頁） ----------
$stmt = $pdo->prepare("SELECT * FROM pname ORDER BY id LIMIT $start, $perPage");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ---------- 總頁數 ----------
$total = $pdo->query("SELECT COUNT(*) FROM pname")->fetchColumn();
$pages = ceil($total / $perPage);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>產品管理</title>
  <style>
    table, th, td { border: 1px solid #999; border-collapse: collapse; padding: 8px; }
    a { margin: 0 5px; }
  </style>
</head>
<body>

<h2>📋 產品列表</h2>
<a href="?new=1">➕ 新增資料</a>
<table>
  <tr>
    <th>ID</th><th>名稱</th><th>規格</th><th>價格</th><th>製作日期</th><th>操作</th>
  </tr>
  <?php foreach ($rows as $row): ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['pname']) ?></td>
      <td><?= htmlspecialchars($row['pspec']) ?></td>
      <td><?= htmlspecialchars($row['price']) ?></td>
      <td><?= htmlspecialchars($row['pdate']) ?></td>
      <td>
        <a href="?view=<?= $row['id'] ?>">檢視</a>
        <a href="?edit=<?= $row['id'] ?>">編輯</a>
        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('確定要刪除？')">刪除</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<div>
  <?php for ($i = 1; $i <= $pages; $i++): ?>
    <a href="?page=<?= $i ?>"><?= $i ?></a>
  <?php endfor; ?>
</div>

<hr>

<?php if (isset($_GET['view']) && $single): ?>
  <h3>🔍 單筆詳細內容</h3>
  <p><strong>ID：</strong><?= htmlspecialchars($single['id']) ?></p>
  <p><strong>產品名稱：</strong><?= htmlspecialchars($single['pname']) ?></p>
  <p><strong>產品規格：</strong><?= htmlspecialchars($single['pspec']) ?></p>
  <p><strong>價格：</strong><?= htmlspecialchars($single['price']) ?></p>
  <p><strong>製作日期：</strong><?= htmlspecialchars($single['pdate']) ?></p>
  <p><strong>內容：</strong><?= nl2br(htmlspecialchars($single['content'])) ?></p>
  <a href="pname.php">← 返回列表</a>
<?php endif; ?>

<?php if (isset($_GET['edit']) && $single): ?>
  <h3>✏️ 編輯資料</h3>
  <form method="post">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?= $single['id'] ?>">
    名稱：<input name="pname" value="<?= htmlspecialchars($single['pname']) ?>"><br>
    規格：<input name="pspec" value="<?= htmlspecialchars($single['pspec']) ?>"><br>
    價格：<input name="price" value="<?= $single['price'] ?>"><br>
    製作日期：<input type="date" name="pdate" value="<?= $single['pdate'] ?>"><br>
    說明：<textarea name="content"><?= htmlspecialchars($single['content']) ?></textarea><br>
    <button type="submit">更新</button>
  </form>
  <a href="pname.php">← 返回列表</a>
<?php endif; ?>

<?php if (isset($_GET['new'])): ?>
  <h3>➕ 新增資料</h3>
  <form method="post">
    <input type="hidden" name="action" value="create">
    ID：<input name="id"><br>
    名稱：<input name="pname"><br>
    規格：<input name="pspec"><br>
    價格：<input name="price"><br>
    製作日期：<input type="date" name="pdate"><br>
    說明：<textarea name="content"></textarea><br>
    <button type="submit">新增</button>
  </form>
  <a href="pname.php">← 返回列表</a>
<?php endif; ?>

</body>
</html>
