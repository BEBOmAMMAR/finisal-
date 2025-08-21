<?php
include 'config.php';



$id = intval($_GET['id'] ?? 0);

// بيانات العميل
$stmt = $conn->prepare("SELECT * FROM customers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

if (!$customer) {
    die("🚨 عميل غير موجود");
}

// إجمالي دخل العميل
$res = $conn->query("SELECT SUM(amount) as total_income 
                     FROM income WHERE id=$id");
$total_income = $res->fetch_assoc()['total_income'] ?? 0;

// إجمالي مصروف العميل
$res = $conn->query("SELECT SUM(amount) as total_expense 
                     FROM expense WHERE customer_id=$id");
$total_expense = $res->fetch_assoc()['total_expense'] ?? 0;

// صافي
$net = $total_income - $total_expense;

// جميع المعاملات (union)
$sql = " SELECT id, date, amount, notes, 'دخل' as type
    FROM income WHERE customer_id=$id
    UNION
    SELECT id, date, amount, notes, 'مصروف' as type
    FROM expense WHERE customer_id=$id
    ORDER BY date DESC
";
$transactions = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>بيان العميل - <?= htmlspecialchars($customer['name']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .widget {
            border-radius: 1rem;
            padding: 1.2rem;
            color: #fff;
            text-align: center;
            font-size: 1.2rem;
        }
        .income { background: linear-gradient(135deg,#28a745,#5cd68d); }
        .expense { background: linear-gradient(135deg,#dc3545,#ff6b81); }
        .net { background: linear-gradient(135deg,#007bff,#66b2ff); }
        .value { font-size:1.6rem; font-weight:bold; }
    </style>
</head>
<body class="container py-4">
    <h2>📑 بيان عميل: <?= htmlspecialchars($customer['name']) ?></h2>
    <p>
        <b>📧</b> <?= htmlspecialchars($customer['email']) ?> <br>
        <b>📞</b> <?= htmlspecialchars($customer['phone']) ?>
    </p>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="widget income">
                💰 إجمالي الدخل <br>
                <span class="value"><?= number_format($total_income,2) ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget expense">
                💸 إجمالي المصروف <br>
                <span class="value"><?= number_format($total_expense,2) ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget net">
                ⚖️ الصافي <br>
                <span class="value"><?= number_format($net,2) ?></span>
            </div>
        </div>
    </div>

    <h4>📋 المعاملات</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>التاريخ</th>
                <th>النوع</th>
                <th>المبلغ</th>
                <th>ملاحظات</th>
            </tr>
        </thead>
        <tbody>
            <?php while($t = $transactions->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($t['date']) ?></td>
                    <td><?= $t['type'] ?></td>
                    <td><?= number_format($t['amount'],2) ?></td>
                    <td><?= htmlspecialchars($t['notes']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="customers.php" class="btn btn-secondary">⬅️ رجوع للعملاء</a>
</body>
</html>
