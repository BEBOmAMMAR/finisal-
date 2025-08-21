<?php  include 'header.php';
 include 'config.php';?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نظام إدارة المصاريف والدخل</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5 text-center">
        <h1 class="mb-4 text-primary"><i class="fa-solid fa-wallet"></i> نظام إدارة المصاريف والدخل</h1>
        <p class="lead text-muted mb-5">إدارة شاملة للدخل والمصروفات، العملاء، والتقارير المالية.</p>

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

