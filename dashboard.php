<?php include "config.php"; 
 include 'header.php'; ?>

<?php
// إجمالي الدخل
$income = $conn->query("SELECT SUM(amount) as total FROM transactions t 
                        LEFT JOIN categories c ON t.category_id=c.id 
                        WHERE c.type='income'")->fetch_assoc()['total'] ?? 0;

// إجمالي المصروف
$expense = $conn->query("SELECT SUM(amount) as total FROM transactions t 
                         LEFT JOIN categories c ON t.category_id=c.id 
                         WHERE c.type='expense'")->fetch_assoc()['total'] ?? 0;

$net = $income - $expense;

// بيانات الرسم البياني
$data = [];
$res = $conn->query("SELECT DATE_FORMAT(t.date, '%Y-%m') as month, 
                            SUM(CASE WHEN c.type='income' THEN amount ELSE 0 END) as income,
                            SUM(CASE WHEN c.type='expense' THEN amount ELSE 0 END) as expense
                     FROM transactions t
                     LEFT JOIN categories c ON t.category_id=c.id
                     GROUP BY month ORDER BY month ASC");
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="container py-4">
    <h2>📊 لوحة التحكم</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ رجوع</a>

    <!-- الكروت -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>💰 إجمالي الدخل</h4>
                    <h2><?= number_format($income,2) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>💸 إجمالي المصاريف</h4>
                    <h2><?= number_format($expense,2) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h4>⚖️ الصافي</h4>
                    <h2><?= number_format($net,2) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسم البياني -->
    <canvas id="financeChart" height="120"></canvas>

    <script>
    const ctx = document.getElementById('financeChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($data, 'month')) ?>,
            datasets: [
                {
                    label: '💰 الدخل',
                    data: <?= json_encode(array_column($data, 'income')) ?>,
                    borderColor: 'green',
                    fill: false
                },
                {
                    label: '💸 المصروف',
                    data: <?= json_encode(array_column($data, 'expense')) ?>,
                    borderColor: 'red',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
    </script>
</body>
</html>
