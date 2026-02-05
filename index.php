<?php
    session_start();
    require 'database.php';

    $queryPlayers = 'SELECT p.contactID, p.firstName, p.lastName, p.dob, p.team, p.goals, p.assists, p.points, p.gamesPlayed, p.imageName, t.playerType
       FROM players p LEFT JOIN types t ON p.typeID = t.typeID';
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
              <th>Player Position</th>
              <th>Picture</th>
              <th>&nbsp;</th><!-- for the edit button -->
              <th>&nbsp;</th><!-- for the delete button -->
              <th>&nbsp;</th><!-- for the view details button -->

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
              <td><?php echo htmlspecialchars($player['playerType']); ?></td>
              <td>
              <img src="<?php echo './assets/images/' . htmlspecialchars($player['imageName']); ?>" 
                alt="<?php echo htmlspecialchars($player['firstName'] . ' ' . $player['lastName']); ?>">
              </td>
              <td><form action="update_contact_form.php" method="post">
                <input type="hidden" name="contact_id" 
                value="<?php echo htmlspecialchars($player['contactID']); ?>">
                <input type="submit" value="Update"></form></td>
              <td><form action="delete_contact.php" method="post">
                <input type="hidden" name="contact_id" 
                value="<?php echo htmlspecialchars($player['contactID']); ?>">
                <input type="submit" value="Delete"></form></td>
              <td><form action="player_details.php" method="post">
                <input type="hidden" name="contact_id" 
                value="<?php echo htmlspecialchars($player['contactID']); ?>">
                <input type="submit" value="View Details"></form></td>
            </tr>
            <?php endforeach; ?>
          </table>

          <p><a href="add_contact_form.php">Add New Player</a></p>

        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>