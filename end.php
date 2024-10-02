<?php
session_start();
require 'db.php'; 

if (!isset($_SESSION['score'])) {
    header("Location: game.php");
    exit();
}

$stmt = $pdo->prepare("UPDATE game_users SET score = GREATEST(score, :score) WHERE id = :user_id");
$stmt->execute(['score' => $_SESSION['score'], 'user_id' => $_SESSION['user_id']]);

$stmt = $pdo->query("SELECT nickname, MAX(score) as score FROM game_users GROUP BY nickname ORDER BY score DESC LIMIT 10");
$leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Game Over</title>
</head>
<body>
    <div class="container">
        <h1>Game Over</h1>
        <p>Your score: <?php echo $_SESSION['score']; ?></p>

        <h2>Leaderboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Nickname</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($leaderboard as $index => $user) {
                    echo "<tr>";
                    echo "<td>" . ($index + 1) . "</td>";
                    echo "<td>" . htmlspecialchars($user['nickname']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['score']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="index.php">Play Again</a>
    </div>
</body>
</html>
