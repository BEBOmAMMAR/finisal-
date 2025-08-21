<?php
include 'config.php';

// إجمالي الدخل
$res = $conn->query("SELECT SUM(amount) as total_income FROM income");
$total_income = $res->fetch_assoc()['total_income'] ?? 0;

// إجمالي المصروف
$res = $conn->query("SELECT SUM(amount) as total_expense FROM expense");
$total_expense = $res->fetch_assoc()['total_expense'] ?? 0;

// الصافي
$net = $total_income - $total_expense;

// بيانات للرسم البياني
$chartData = [];
$sql = "
    SELECT DATE_FORMAT(date, '%Y-%m') as ym, SUM(amount) as total, 'income' as type 
    FROM income GROUP BY ym
    UNION
    SELECT DATE_FORMAT(date, '%Y-%m') as ym, SUM(amount) as total, 'expense' as type 
    FROM expense GROUP BY ym
    ORDER BY ym ASC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $chartData[] = $row;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.6.2/countUp.min.js"></script>
    <style>
        .widget {
            border-radius: 1rem;
            color: #171616ff;
            padding: 1.5rem;
            text-align: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .income { background: linear-gradient(135deg, #28a745, #5cd68d); }
        .expense { background: linear-gradient(135deg, #dc3545, #ff6b81); }
        .net { background: linear-gradient(135deg, #007bff, #66b2ff); }
        .value { font-size: 2rem; font-weight: bold; }
    </style>
</head>
<body class="container py-4">
    <h2 class="mb-4">📊 لوحة التحكم</h2>

    <!-- Widgets -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="widget income">
                💰 إجمالي الدخل <br>
                <span id="incomeVal" class="value">0</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget expense">
                💸 إجمالي المصروف <br>
                <span id="expenseVal" class="value">0</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget net">
                ⚖️ الصافي <br>
                <span id="netVal" class="value">0</span>
            </div>
        </div>
    </div>

    <!-- الرسم البياني -->
    <canvas id="financeChart" height="100"></canvas>

    <script>
        // تشغيل عداد الأرقام
        new CountUp("incomeVal", <?= $total_income ?>, {duration: 2, separator: ','}).start();
        new CountUp("expenseVal", <?= $total_expense ?>, {duration: 2, separator: ','}).start();
        new CountUp("netVal", <?= $net ?>, {duration: 2, separator: ','}).start();

        // الرسم البياني
        const chartData = <?= json_encode($chartData) ?>;
        const labels = [...new Set(chartData.map(item => item.ym))];
        const incomeData = labels.map(l => {
            const f = chartData.find(x => x.ym === l && x.type === 'income');
            return f ? f.total : 0;
        });
        const expenseData = labels.map(l => {
            const f = chartData.find(x => x.ym === l && x.type === 'expense');
            return f ? f.total : 0;
        });

        const ctx = document.getElementById('financeChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'الدخل',
                        data: incomeData,
                        borderColor: 'green',
                        backgroundColor: 'rgba(40,167,69,0.2)',
                        fill: true
                    },
                    {
                        label: 'المصروف',
                        data: expenseData,
                        borderColor: 'red',
                        backgroundColor: 'rgba(220,53,69,0.2)',
                        fill: true
                    }
                ]
            }
        });
    </script>
</body>
</html>
