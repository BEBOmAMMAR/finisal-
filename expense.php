<?php
include 'config.php';

// إضافة مصروف
if (isset($_POST['add_expense'])) {
    $customer_id = $_POST['customer_id'] ?: "NULL";
    $category_id = $_POST['category_id'];
    $amount      = $_POST['amount'];
    $desc        = $_POST['description'];
    $date        = $_POST['date'];

    $sql = "INSERT INTO expense (customer_id, category_id, amount, description, date) 
            VALUES ($customer_id, $category_id, $amount, '$desc', '$date')";
    $conn->query($sql);
    header("Location: expense.php");
    exit;
}

// حذف مصروف
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM expense WHERE id=$id");
    header("Location: expense.php");
    exit;
}

// جلب بيانات
$customers = $conn->query("SELECT * FROM customers");
$categories = $conn->query("SELECT * FROM expense_categories");
$expenses = $conn->query("SELECT e.*, c.name AS customer, cat.name AS category 
                         FROM expense e
                         LEFT JOIN customers c ON e.customer_id = c.id
                         JOIN expense_categories cat ON e.category_id = cat.id
                         ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة المصروفات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2 class="mb-4">💸 إدارة المصروفات</h2>
<a href="index.php" class="btn btn-secondary mb-3">⬅ رجوع</a>

    <!-- نموذج إضافة مصروف -->
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="customer_id" class="form-control">
                <option value="">بدون عميل</option>
                <?php while($c = $customers->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-control" required>
                <option value="">تصنيف</option>
                <?php while($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="amount" class="form-control" placeholder="المبلغ" required>
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="description" class="form-control" placeholder="الوصف">
        </div>
        <div class="col-md-12">
            <button type="submit" name="add_expense" class="btn btn-danger">➖ إضافة</button>
        </div>
    </form>

    <!-- جدول المصروفات -->
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>العميل</th>
                <th>التصنيف</th>
                <th>المبلغ</th>
                <th>الوصف</th>
                <th>التاريخ</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $expenses->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['customer'] ?: 'بدون' ?></td>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td>
                        <a href="expense.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
