<?php
include "config.php";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=report.csv');
$output = fopen("php://output", "w");

// رؤوس الأعمدة
fputcsv($output, ['العميل','التصنيف','النوع','المبلغ','التاريخ','ملاحظة']);

// فلترة
$where = "1";
if (!empty($_GET['from']) && !empty($_GET['to'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $where .= " AND t.date BETWEEN '$from' AND '$to'";
}
if (!empty($_GET['type'])) {
    $type = $_GET['type'];
    $where .= " AND cat.type='$type'";
}

$sql = "SELECT t.*, c.name as customer, cat.name as category, cat.type 
        FROM transactions t
        LEFT JOIN customers c ON t.customer_id=c.id
        LEFT JOIN categories cat ON t.category_id=cat.id
        WHERE $where ORDER BY t.date DESC";
$res = $conn->query($sql);

while ($row = $res->fetch_assoc()) {
    $type = $row['type']=='income'?'دخل':'مصروف';
    fputcsv($output, [$row['customer'],$row['category'],$type,$row['amount'],$row['date'],$row['note']]);
}

fclose($output);
exit;
?>
