<?php
session_start();
?>

<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Adidas</title>
    <link rel="stylesheet" href="about.css">

<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>

</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 0;
}

.about-hero {
    background: #111;
    color: #fff;
    padding: 80px 20px;
    text-align: center;
}

.hero-content h1 {
    font-size: 48px;
    margin-bottom: 10px;
}

.hero-content p {
    font-size: 20px;
    opacity: 0.8;
}

.about-section {
    padding: 60px 20px;
}

.about-block {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    max-width: 1100px;
    margin: 0 auto 40px auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.05);
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.8s ease forwards;
}

.about-block.light-background {
    background-color: #f8f9fa;
}

.about-text {
    max-width: 800px;
    text-align: left;
}

.about-text h2 {
    font-size: 28px;
    color: #111;
    margin-bottom: 15px;
}

.about-text p {
    font-size: 17px;
    color: #555;
    line-height: 1.8;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 36px;
    }

    .hero-content p {
        font-size: 18px;
    }

    .about-block {
        flex-direction: column;
        padding: 40px 15px;
    }

    .about-text {
        text-align: center;
    }

    .about-text h2 {
        font-size: 24px;
    }

    .about-text p {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .about-hero {
        padding: 60px 15px;
    }

    .about-text p {
        font-size: 15px;
    }
}

</style>

<body>

<?php
    include 'header.php';
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-C807FPWHC8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-C807FPWHC8');
</script>

<section class="about-hero">
    <div class="hero-content">
        <h1>About adidas</h1>
        <p>Stories, style, and sporting goods, since 1949.</p>
    </div>
</section>

<section class="about-section">
    <div class="about-block">
        <div class="about-text">
            <h2>Changing Lives Through Sport</h2>
            <p>Through sports, we have the power to change lives. Sports keep us fit. They keep us mindful. They bring us together. Athletes inspire us. They help us to get up and get moving. And sporting goods featuring the latest technologies help us beat our personal best...</p>
        </div>
    </div>

    <div class="about-block light-background">
        <div class="about-text">
            <h2>More Than Sportswear</h2>
            <p>adidas is about more than sportswear and workout clothes. We partner with the best in the industry to co-create. This way we offer our fans the sporting goods, style and clothing that match the athletic needs, while keeping sustainability in mind...</p>
        </div>
    </div>

    <div class="about-block">
        <div class="about-text">
            <h2>Workout Clothes for Any Sport</h2>
            <p>adidas designs for athletes of all kinds. Creators who love to change the game. People who challenge conventions, break the rules, and define new ones. Then break them all over again. We design sports apparel that gets you moving, winning, and living life to the fullest...</p>
        </div>
    </div>
</section>

<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="adidasBot"
  agent-id="59558269-3c1a-4489-80ac-8a15a152be07"
  language-code="en"
></df-messenger>


</body>
</html>
