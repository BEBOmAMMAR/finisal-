<?php require_once __DIR__.'/config.php'; ?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>إدارة المصاريف والدخل</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">المالية</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="customers.php">العملاء</a></li>
        <li class="nav-item"><a class="nav-link" href="categories.php">التصنيفات</a></li>
        <li class="nav-item"><a class="nav-link" href="transactions.php">المعاملات</a></li>
        <li class="nav-item"><a class="nav-link" href="income.php">الدخل </a></li>
        <li class="nav-item"><a class="nav-link" href="expense.php"> المصاريف </a></li>

        <li class="nav-item"><a class="nav-link" href="report.php">التقارير</a></li>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">