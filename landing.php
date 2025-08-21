<?php
include "config.php";

// إجمالي الدخل
$res_income = $conn->query("SELECT SUM(amount) AS total_income FROM transactions WHERE type='income'");
$total_income = $res_income->fetch_assoc()['total_income'] ?? 0;

// إجمالي المصروف
$res_expense = $conn->query("SELECT SUM(amount) AS total_expense FROM transactions WHERE type='expense'");
$total_expense = $res_expense->fetch_assoc()['total_expense'] ?? 0;

// الصافي
$balance = $total_income - $total_expense;
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نظام إدارة المصاريف والدخل</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .stat-card {
            color: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            background-size: 300% 300%;
            animation: gradientMove 6s ease infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .income-bg {
            background: linear-gradient(45deg, #28a745, #5be584, #20c997);
        }
        .expense-bg {
            background: linear-gradient(45deg, #dc3545, #ff6b6b, #c82333);
        }
        .balance-bg {
            background: linear-gradient(45deg, #007bff, #00c6ff, #6610f2);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5 text-center">
        <h1 class="mb-3 text-primary"><i class="fa-solid fa-wallet"></i> نظام إدارة المصاريف والدخل</h1>
        <p class="lead text-muted mb-5">إدارة شاملة للدخل والمصروفات، العملاء، والتقارير المالية.</p>

        <!-- الإحصائيات السريعة -->
        <div class="row mb-5 g-4">
            <div class="col-md-4">
                <div class="stat-card income-bg">
                    <h5><i class="fa-solid fa-circle-arrow-up"></i> إجمالي الدخل</h5>
                    <h2><?= number_format($total_income, 2) ?> ر.س</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card expense-bg">
                    <h5><i class="fa-solid fa-circle-arrow-down"></i> إجمالي المصروف</h5>
                    <h2><?= number_format($total_expense, 2) ?> ر.س</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card balance-bg">
                    <h5><i class="fa-solid fa-scale-balanced"></i> الصافي</h5>
                    <h2><?= number_format($balance, 2) ?> ر.س</h2>
                </div>
            </div>
        </div>

        <!-- روابط النظام -->
        <div class="row g-4">
            <div class="col-md-4">
                <a href="dashboard.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-chart-line fa-3x text-primary mb-3"></i>
                            <h4>لوحة التحكم</h4>
                            <p class="text-muted">ملخص مالي ورسم بياني تفاعلي</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="customers.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-users fa-3x text-success mb-3"></i>
                            <h4>العملاء</h4>
                            <p class="text-muted">إدارة بيانات العملاء</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="categories.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-tags fa-3x text-warning mb-3"></i>
                            <h4>التصنيفات</h4>
                            <p class="text-muted">إضافة وتصنيف الدخل والمصروف</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="transactions.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-credit-card fa-3x text-danger mb-3"></i>
                            <h4>المعاملات</h4>
                            <p class="text-muted">تسجيل وتتبع المعاملات المالية</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="report.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-file-invoice fa-3x text-info mb-3"></i>
                            <h4>التقارير</h4>
                            <p class="text-muted">عرض وتحليل التقارير المالية</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="export_csv.php" class="text-decoration-none">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <i class="fa-solid fa-download fa-3x text-secondary mb-3"></i>
                            <h4>تصدير CSV</h4>
                            <p class="text-muted">تحميل بياناتك بتنسيق CSV</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
