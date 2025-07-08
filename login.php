<?php
session_start();
ob_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "connect.php";
?>	

<!DOCTYPE html>
<title>Sistem Akuntansi Nusaputera</title>
<link href="css/bootstrap.min.css" rel="stylesheet"><br><br>
<style>
body {
    background-color: #F5F7FA;
    background-image: linear-gradient(135deg, rgba(0, 115, 230, 0.08) 25%, transparent 25%),
                      linear-gradient(225deg, rgba(255, 215, 0, 0.08) 25%, transparent 25%);
    background-size: 50px 50px;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}



		.login {
			background: white;
			padding: 30px;
			border-radius: 16px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
			width: 100%;
			max-width: 400px;
			text-align: center;
			transform: translateY(0);
			transition: transform 0.3s ease-in-out;
		}
		.login:hover {
			transform: translateY(-5px);
		}

        .form-control {
            padding-left: 40px;
        }
        .input-group-text {
            background: none;
            border-right: none;
        }
        .btn-primary {
            background-color: #4A90E2;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #357ABD;
        }
        .logo {
            width: 100px;
            margin-bottom: 15px;
        }
    </style>

<body>

<div class="login">
    <img src="nusput.png" alt="Logo Sekolah" class="logo">
    <h3 class="text-primary fw-bold">Sistem Akuntansi Sekolah Nasional Nusaputera</h3>
    <p class="text-muted">Silakan login untuk melanjutkan</p>

		<form role="form" action="" method="post"><br>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
		<button type="submit" name="login" class="btn btn-primary w-100" value="login">Login</button>
		</form>
		<footer class="text-center mt-4 text-muted small">
        &copy; 2023 - Alvin Handoyo & Ervina Graciella
    </footer>	

</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = hash('sha512', $_POST['password']);

    // Gunakan Prepared Statements untuk mencegah SQL Injection
    $stmt = $konektor->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
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
        exit();
    } else {
        echo '<center><div class="alert alert-danger">Login gagal, username atau password salah.</div></center>';
    }
    
    $stmt->close();
}
?>
