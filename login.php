<?php
include 'db_connection.php';
session_start();

$email = $password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if (empty($email) || empty($password)) {
    $errors[] = "Both fields are required.";
  } else {
    $stmt = mysqli_prepare($conn, "SELECT user_id, password, role FROM user WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) === 1) {
      mysqli_stmt_bind_result($stmt, $user_id, $hashed_password, $role);
      mysqli_stmt_fetch($stmt);
      if ($password === $hashed_password) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        if ($role === 'admin') {
          header("Location: admin_dashboard.php");
        } else {
          header("Location: index.php");
        }
        exit;
      } else {
        $errors[] = "Invalid credentials.";
      }
    mysqli_stmt_close($stmt);
  }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f0f0f0, #ffffff);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
    }
    header {
      width: 100%;
      background-color: #fff;
      padding: 20px 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    header img {
      height: 40px;
    }
    header .brand {
      font-size: 24px;
      font-weight: 700;
      letter-spacing: 2px;
      margin-left: 10px;
      text-transform: lowercase;
      color: #111;
    }
    .login-container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      margin-top: 40px;
      animation: slideFadeIn 0.6s ease-out forwards;
      opacity: 0;
      transform: translateY(20px);
    }
    @keyframes slideFadeIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 1.8rem;
      text-transform: uppercase;
    }
    
    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 12px 16px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      font-family: 'Segoe UI', sans-serif;
      box-sizing: border-box;
    }

    .login-container input[type="submit"] {
      width: 100%;
      padding: 12px;
      background: #000;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s;
    }
    .login-container input[type="submit"]:hover {
      background: #222;
    }
    .login-container .link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.95rem;
    }
    .login-container .link a {
      color: #000;
      text-decoration: underline;
    }
    .error {
      background: #ffdddd;
      padding: 10px;
      margin-bottom: 15px;
      border-left: 4px solid #f44336;
      color: #a94442;
      border-radius: 5px;
    }

@media (max-width: 768px) {
  header {
    padding: 15px 20px;
    margin-bottom: 40px;
  }
  header img {
    height: 30px;
  }
  header .brand {
    font-size: 20px;
  }
  .login-container {
    padding: 20px;
    margin-top: 50px;
    width: 90%;
    max-width: 350px; 
  }
  .login-container h2 {
    font-size: 1.5rem;
  }
  .login-container input[type="email"],
  .login-container input[type="password"],
  .login-container input[type="submit"] {
    padding: 10px;
    font-size: 0.9rem;
  }
  .login-container .link {
    font-size: 0.85rem;
  }
}

@media (max-width: 480px) {
  header {
    padding: 10px 15px;
  }
  header img {
    height: 25px;
  }
  header .brand {
    font-size: 18px;
  }
  .login-container {
    padding: 15px;
    margin-top: 15px;
    width: 95%;
    max-width: 300px;
  }
  .login-container h2 {
    font-size: 1.3rem;
  }
  .login-container input[type="email"],
  .login-container input[type="password"],
  .login-container input[type="submit"] {
    padding: 8px;
    font-size: 0.85rem;
  }
  .login-container .link {
    font-size: 0.8rem;
  }
}

  </style>
</head>
<body>

  <header>
    <img src="logo/logo-removebg-preview.png" alt="Adidas Logo">
    <span class="brand">adidas</span>
  </header>

  <div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($errors)): ?>
      <div class="error">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <form action="" method="POST">
      <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
      <input type="password" name="password" placeholder="Password">
      <input type="submit" value="Log In">
    </form>
    <div class="link">
      Don’t have an account? <a href="signup.php">Create one</a>
    </div>
  </div>
</body>
</html>
