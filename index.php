<?php
session_start();
require 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];

    
    $stmt = $pdo->prepare("INSERT INTO game_users (nickname) VALUES (:nickname)");
    $stmt->execute(['nickname' => $nickname]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['nickname'] = $nickname;
    $_SESSION['score'] = 0;
    $_SESSION['round'] = 1;

    header("Location: game.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spelling Mini-Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Spelling Mini-Game</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Spelling Game!</h1>
        
        <div class="content">
        <div class="rules">
        <h2>Game Rules</h2> 
        <div class="rule-box">1. You will have 5 rounds.</div>
        <div class="rule-box">2. Spell the given word correctly.</div>
        <div class="rule-box">3. You have 5 seconds to answer each round.</div> 
        <div class="rule-box">4. Earn 1 point for each correct answer.</div>
        <div class="rule-box">5. Try to achieve the highest score!</div>
    </div>
            
            <form method="POST" action="index.php" id="gameForm">
                <br><br><br><br><br><br>
                <label>Enter your nickname:</label>
                <input type="text" name="nickname" required>
                
                <div>
                    <input type="checkbox" id="rulesCheckbox" required>
                    <label for="rulesCheckbox">I understand the rules</label>
                    <br>
                </div>
                <br>
                <button type="submit">Start Game</button>
            </form>
        </div>
    </div>
</body>
</html>

</html>
