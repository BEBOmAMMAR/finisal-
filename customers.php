<?php include "config.php";
 include 'header.php'; ?>
 

<?php
// إضافة عميل جديد
if (isset($_POST['add'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $conn->query("INSERT INTO customers (name, email, phone) VALUES ('$name','$email','$phone')");
    header("Location: customers.php");
}

// حذف عميل
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM customers WHERE id=$id");
    header("Location: customers.php");
}

// تعديل عميل
if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $conn->query("UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id=$id");
    header("Location: customers.php");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة العملاء</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h2>👤 إدارة العملاء</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ رجوع</a>

    <!-- نموذج إضافة -->
    <form method="post" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control" placeholder="اسم العميل" required>
        </div>
        <div class="col-md-3">
            <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني">
        </div>
        <div class="col-md-3">
            <input type="text" name="phone" class="form-control" placeholder="رقم الهاتف">
        </div>
        <div class="col-md-3">
            <button type="submit" name="add" class="btn btn-success">➕ إضافة</button>
        </div>
    </form>

    <!-- جدول العملاء -->
    <table class="table table-bordered">
        <tr class="table-light">
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>الإجراءات</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM customers ORDER BY id DESC");
        while ($row = $res->fetch_assoc()):
        ?>
            <tr>
                <form method="post">
                    <td>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control">
                    </td>
                    <td>
                        <input type="email" name="email" value="<?= $row['email'] ?>" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="phone" value="<?= $row['phone'] ?>" class="form-control">
                    </td>
                    <td>
                        <button type="submit" name="update" class="btn btn-primary btn-sm">💾 تحديث</button>
                        <a href="customers.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑 حذف</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
