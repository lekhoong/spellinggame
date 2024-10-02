<?php
session_start();
require 'db.php'; 

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
if (!isset($_SESSION['round'])) {
    $_SESSION['round'] = 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_answer = strtolower(trim($_POST['answer']));
    $correct_answer = strtolower($_SESSION['word']);
    
    if ($user_answer === $correct_answer) {
        $_SESSION['score'] += 1;
        $message = "<p class='success'>Correct! Your score is: {$_SESSION['score']}</p>";
    } else {
        $message = "<p class='error'>Wrong! The correct answer is: $correct_answer</p>";
    }

    $_SESSION['round'] += 1;
    if ($_SESSION['round'] > 5) {
     
        $stmt = $pdo->prepare("UPDATE game_users SET score = :score WHERE id = :user_id");
        $stmt->execute(['score' => $_SESSION['score'], 'user_id' => $_SESSION['user_id']]);

        header("Location: end.php");
        exit();
    }
}


$words = ['apple', 'banana', 'orange', 'pear', 'grape', 'pineapple', 'watermelon'];
$_SESSION['word'] = $words[array_rand($words)];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Spelling Mini-Game</title>
    <script>
    let timer;
    let timeLimit = 5; 
    let timeRemaining = timeLimit;

    function startTimer() {
        const countdownElement = document.getElementById('countdown');
        countdownElement.innerHTML = timeRemaining; 
        
        timer = setInterval(function() {
            timeRemaining--;
            countdownElement.innerHTML = timeRemaining; 
            
            if (timeRemaining <= 0) {
                clearInterval(timer);
                document.getElementById('answerForm').submit(); 
            }
        }, 1000); 
    }

    function resetTimer() {
        clearInterval(timer);
        timeRemaining = timeLimit; 
        startTimer();
    }

    window.onload = function() {
        startTimer()
        document.getElementById('answer').focus(); 
    };
</script>

</head>
<body>
    <div class="container">
        <h1>Round <?php echo $_SESSION['round']; ?></h1>
        <p>Spell the following word:</p>
        <h2><?php echo $_SESSION['word']; ?></h2>


        <?php if (isset($message)) echo $message; ?>

        <p>Time Remaining: <span id="countdown"><?php echo $timeLimit; ?></span> seconds</p> 

        <form method="POST" action="game.php" id="answerForm" onsubmit="resetTimer();">
        <input type="text" name="answer" id="answer" required>
            <br>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
