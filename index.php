<?php
    require 'database.php';

    $queryPlayers = 'SELECT firstName, lastName, dob, team, goals, assists, points, gamesPlayed
       FROM players';
    $statement = $db->prepare($queryPlayers);
    $statement->execute();
    $players= $statement->fetchAll();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Hockey Players</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>Player List</h2>
          <table>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Date of Birth</th>
              <th>Team</th>
              <th>Goals</th>
              <th>Assists</th>
              <th>Points</th>
              <th>Games Played</th>

            </tr>
            <?php foreach ($players as $player): ?>
            <tr>
              <td><?php echo htmlspecialchars($player['firstName']); ?></td>
              <td><?php echo htmlspecialchars($player['lastName']); ?></td>
              <td><?php echo htmlspecialchars($player['dob']); ?></td>
              <td><?php echo htmlspecialchars($player['team']); ?></td>
              <td><?php echo htmlspecialchars($player['goals']); ?></td>
              <td><?php echo htmlspecialchars($player['assists']); ?></td>
              <td><?php echo htmlspecialchars($player['points']); ?></td>
              <td><?php echo htmlspecialchars($player['gamesPlayed']); ?></td>
            </tr>
            <?php endforeach; ?>
          </table>


        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>