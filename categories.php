<?php include 'header.php'; 
 include "config.php"; ?>

<?php
// إضافة تصنيف
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $type = $_POST['type']; // income أو expense
    $conn->query("INSERT INTO categories (name, type) VALUES ('$name','$type')");
    header("Location: categories.php");
}

// حذف تصنيف
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id=$id");
    header("Location: categories.php");
}

// تعديل تصنيف
if (isset($_POST['update'])) {
    $id   = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $conn->query("UPDATE categories SET name='$name', type='$type' WHERE id=$id");
    header("Location: categories.php");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة التصنيفات</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>📂 إدارة التصنيفات</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ رجوع</a>

    <!-- نموذج إضافة -->
    <form method="post" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="اسم التصنيف" required>
        </div>
        <div class="col-md-3">
            <select name="type" class="form-control" required>
                <option value="income">دخل</option>
                <option value="expense">مصروف</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" name="add" class="btn btn-success">➕ إضافة</button>
        </div>
    </form>

    <!-- جدول التصنيفات -->
    <table class="table table-bordered">
        <tr>
            <th>الاسم</th>
            <th>النوع</th>
            <th>الإجراءات</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM categories ORDER BY id DESC");
        while ($row = $res->fetch_assoc()):
        ?>
            <tr>
                <form method="post">
                    <td>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control">
                    </td>
                    <td>
                        <select name="type" class="form-control">
                            <option value="income" <?= $row['type']=='income'?'selected':'' ?>>دخل</option>
                            <option value="expense" <?= $row['type']=='expense'?'selected':'' ?>>مصروف</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" name="update" class="btn btn-primary btn-sm">💾 تحديث</button>
                        <a href="categories.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑 حذف</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
