<?php include "config.php";
 include 'header.php';  ?>

<?php
$where = "1";
if (!empty($_GET['from']) && !empty($_GET['to'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $where .= " AND t.date BETWEEN '$from' AND '$to'";
}
if (!empty($_GET['type'])) {
    $type = $_GET['type'];
    $where .= " AND cat.type='$type'";
}

$sql = "SELECT t.*, c.name as customer, cat.name as category, cat.type 
        FROM transactions t
        LEFT JOIN customers c ON t.customer_id=c.id
        LEFT JOIN categories cat ON t.category_id=cat.id
        WHERE $where ORDER BY t.date DESC";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>التقارير</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>📑 التقارير</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ رجوع</a>

    <!-- فلاتر -->
    <form method="get" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="date" name="from" class="form-control" value="<?= $_GET['from'] ?? '' ?>">
        </div>
        <div class="col-md-3">
            <input type="date" name="to" class="form-control" value="<?= $_GET['to'] ?? '' ?>">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-control">
                <option value="">الكل</option>
                <option value="income" <?= (($_GET['type']??'')=='income'?'selected':'') ?>>دخل</option>
                <option value="expense" <?= (($_GET['type']??'')=='expense'?'selected':'') ?>>مصروف</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">🔍 بحث</button>
            <a href="export_csv.php?from=<?= $_GET['from'] ?? '' ?>&to=<?= $_GET['to'] ?? '' ?>&type=<?= $_GET['type'] ?? '' ?>" class="btn btn-success">⬇ تصدير CSV</a>
        </div>
    </form>

    <!-- جدول -->
    <table class="table table-bordered">
        <tr>
            <th>العميل</th>
            <th>التصنيف</th>
            <th>المبلغ</th>
            <th>التاريخ</th>
            <th>ملاحظة</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?= $row['customer'] ?></td>
                <td><?= $row['category'] ?> (<?= $row['type']=='income'?'دخل':'مصروف' ?>)</td>
                <td><?= $row['amount'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['note'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
