<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Required</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f4f4;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .message-box {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      text-align: center;
    }
    .message-box h2 {
      margin-bottom: 20px;
      color: #333;
    }
    .message-box a {
      display: inline-block;
      margin: 10px;
      padding: 12px 24px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
    }
    .login-btn {
      background: #000;
      color: white;
    }
    .signup-btn {
      background: #fff;
      border: 1px solid #000;
      color: #000;
    }
  </style>
</head>
<body>
  <div class="message-box">
    <h2>🛑 You need to be logged in to access this page.</h2>
    <a href="login.php" class="login-btn">Log In</a>
    <a href="signup.php" class="signup-btn">Sign Up</a>
  </div>
</body>
</html>
