<?php
include 'db_connection.php';
session_start();

$name = $email = $password = $confirm_password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
    $errors[] = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  } elseif ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
  } elseif (strlen($password) < 8 || 
           !preg_match('/[A-Z]/', $password) || 
           !preg_match('/[0-9]/', $password) ||
           !preg_match('/[a-z]/', $password)) {
    $errors[] = "Password must be at least 8 characters, include a number, a lowercase, and an uppercase letter.";
  }  else {
    $emailCheck = mysqli_prepare($conn, "SELECT user_id FROM user WHERE email = ?");
    mysqli_stmt_bind_param($emailCheck, "s", $email);
    mysqli_stmt_execute($emailCheck);
    mysqli_stmt_store_result($emailCheck);

    if (mysqli_stmt_num_rows($emailCheck) > 0) {
      $errors[] = "Email is already registered.";
    } else {
      $date_joined = date('Y-m-d');
      $stmt = mysqli_prepare($conn, "INSERT INTO user (name, email, password, date_joined) VALUES (?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $date_joined);
      if (mysqli_stmt_execute($stmt)) {
        header("Location: login.php");
        exit;
      } else {
        $errors[] = "Something went wrong. Please try again.";
      }
    }
    mysqli_stmt_close($emailCheck);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
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

    .signup-container {
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

    .signup-container h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 1.8rem;
      text-transform: uppercase;
    }

    .signup-container input[type="text"],
    .signup-container input[type="email"],
    .signup-container input[type="password"] {
      width: 100%;
      padding: 12px 16px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      box-sizing: border-box;
    }
    .signup-container input[type="submit"] {
      width: 100%;
      padding: 12px;
      background: #000;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .signup-container input[type="submit"]:hover {
      background: #222;
    }
    .error {
      background: #ffdddd;
      padding: 10px;
      margin-bottom: 15px;
      border-left: 4px solid #f44336;
      color: #a94442;
      border-radius: 5px;
    }
    .signup-container .link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.95rem;
    }
    .signup-container .link a {
      color: #000;
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      header {
        padding: 15px 20px;
      }
      header img {
        height: 30px;
      }
      header .brand {
        font-size: 20px;
      }
      .signup-container {
        padding: 20px;
        margin-top: 20px;
        width: 90%;
        max-width: 350px;
      }
      .signup-container h2 {
        font-size: 1.5rem;
      }
      .signup-container input[type="text"],
      .signup-container input[type="email"],
      .signup-container input[type="password"],
      .signup-container input[type="submit"] {
        padding: 10px;
        font-size: 0.9rem;
      }
      .signup-container .link {
        font-size: 0.85rem;
      }
}

    @media (max-width: 480px) {
      header {
        padding: 10px 15px;
        margin-bottom: 40px;
      }
      header img {
        height: 25px;
      }
      header .brand {
        font-size: 18px;
      }
      .signup-container {
        padding: 15px;
        margin-top: 15px;
        width: 95%;
        max-width: 300px;
      }
      .signup-container h2 {
        font-size: 1.3rem;
      }
      .signup-container input[type="text"],
      .signup-container input[type="email"],
      .signup-container input[type="password"],
      .signup-container input[type="submit"] {
        padding: 8px;
        font-size: 0.85rem;
      }
      .signup-container .link {
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

  <div class="signup-container">
    <h2>Sign Up</h2>
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
      <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($name); ?>">
      <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
      <input type="password" name="password" placeholder="Password">
      <input type="password" name="confirm_password" placeholder="Confirm Password">
      <input type="submit" value="Create Account">
    </form>
    <div class="link">
      <a href="login.php">Back to login</a>
    </div>
  </div>
</body>
</html>
