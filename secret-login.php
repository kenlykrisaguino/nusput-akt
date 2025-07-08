<?php
session_start();
// Set header agar browser tahu ini adalah respons JSON
header('Content-Type: application/json');

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_nusput_akt';

// 1. Tambahkan pengecekan koneksi database
$konektor = new mysqli($host, $user, $pass, $db);
if ($konektor->connect_error) {
    die(json_encode([
        'status' => false,
        'error' => 'Connection failed: ' . $konektor->connect_error,
    ]));
}

if (!isset($_GET['secret'])) {
    die(json_encode([
        'status' => false,
        'error' => 'Secret parameter is missing',
    ]));
}

$secret = $_GET['secret'];
$key = 'nusaputer4';
$method = 'AES-128-CTR';

$data = base64_decode($secret);
if ($data === false) {
    die(json_encode([
        'status' => false,
        'error' => 'Invalid base64 data',
    ]));
}

$ivLength = openssl_cipher_iv_length($method);
$iv = substr($data, 0, $ivLength);
$cipherText = substr($data, $ivLength);

$string = openssl_decrypt($cipherText, $method, $key, 0, $iv);

if (!$string) {
    die(json_encode([
        'status' => false,
        'error' => 'Failed to Decrypt Details',
    ]));
}

$decrypted = explode('|-|', $string);
if (count($decrypted) != 2) {
    die(json_encode([
        'status' => false,
        'error' => 'Invalid Details format',
    ]));
}

[$user, $bill] = $decrypted;

$stmt = $konektor->prepare("SELECT * FROM user WHERE username = ?");
if ($stmt === false) {
    die(json_encode([
        'status' => false,
        'error' => 'Failed to prepare statement: ' . $konektor->error,
    ]));
}

$stmt->bind_param('s', $user);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    $_SESSION['user_id'] = $data['id'];

        switch ($data['admin']) {
            case 'adminutama':
                $_SESSION['adminutama'] = $data['id'];
                header("Location: index.php");
                break;
            case 'adminsatu':
            case 'admindua':
            case 'admin':
                $_SESSION['adminsatu'] = $data['id'];
                header("Location: index2.php");
                break;
            case 'admintiga':
            case 'adminempat':
                $_SESSION['admintiga'] = $data['id'];
                header("Location: index3.php");
                break;
            case 'adminlima':
                $_SESSION['adminlima'] = $data['id'];
                header("Location: index.php");
                break;
            default:
                echo '<center><div class="alert alert-danger">Hak akses tidak valid.</div></center>';
                break;
        }
} else {
    echo json_encode([
        'status' => false,
        'error' => 'User not found',
    ]);
}

$stmt->close();
$konektor->close();
