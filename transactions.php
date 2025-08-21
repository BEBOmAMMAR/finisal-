<?php include "config.php"; 
 include "header.php"; ?>


<?php
// إضافة معاملة
if (isset($_POST['add'])) {
    $customer_id = $_POST['customer_id'];
    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $note = $_POST['note'];

    $conn->query("INSERT INTO transactions (customer_id, category_id, amount, date, note)
                  VALUES ('$customer_id','$category_id','$amount','$date','$note')");
    header("Location: transactions.php");
}

// حذف معاملة
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM transactions WHERE id=$id");
    header("Location: transactions.php");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>المعاملات</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>💳 إدارة المعاملات</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ رجوع</a>

    <!-- نموذج إضافة -->
    <form method="post" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="customer_id" class="form-control" required>
                <option value="">اختر العميل</option>
                <?php
                $res = $conn->query("SELECT * FROM customers");
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-control" required>
                <option value="">اختر التصنيف</option>
                <?php
                $res = $conn->query("SELECT * FROM categories");
                while ($row = $res->fetch_assoc()) {
                    $type = $row['type']=='income'?'دخل':'مصروف';
                    echo "<option value='{$row['id']}'>{$row['name']} - $type</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="amount" class="form-control" placeholder="المبلغ" required>
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="note" class="form-control" placeholder="ملاحظات">
        </div>
        <div class="col-12">
            <button type="submit" name="add" class="btn btn-success">➕ إضافة</button>
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
            <th>إجراء</th>
        </tr>
        <?php
        $res = $conn->query("SELECT t.*, c.name as customer, cat.name as category, cat.type 
                             FROM transactions t
                             LEFT JOIN customers c ON t.customer_id=c.id
                             LEFT JOIN categories cat ON t.category_id=cat.id
                             ORDER BY t.date DESC");
        while ($row = $res->fetch_assoc()) {
            $type = $row['type']=='income'?'دخل':'مصروف';
            echo "<tr>
                <td>{$row['customer']}</td>
                <td>{$row['category']} ($type)</td>
                <td>{$row['amount']}</td>
                <td>{$row['date']}</td>
                <td>{$row['note']}</td>
                <td><a href='transactions.php?delete={$row['id']}' class='btn btn-danger btn-sm'>🗑 حذف</a></td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
