<?php
mysqli_report (MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	session_start();
include 'connect.php';

$params = [
    'start_date' => $_GET['start_date'],
    'end_date'   => $_GET['end_date'],
];
$param_query = "";

if($params['start_date'] != ''){
    $param_query .= " AND tanggal >= $params[start_date]";
}
if($params['end_date'] != ''){
    $param_query .= " AND tanggal <= $params[end_date]";
}

$query = "SELECT SUM(debit) AS debit, SUM(kredit) AS kredit FROM transaksi WHERE status = 1 AND sumber_dana != '' $param_query";

$sql = $konektor->query($query);

$data = $sql->fetch_assoc();

header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'message' => "Berhasil mendapatkan data transaksi",
    'data' => $data
]);