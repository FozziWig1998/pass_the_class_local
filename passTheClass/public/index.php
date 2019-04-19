<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body class="main">
    <!-- <?php include "templates/header.php"; ?> -->


    <?php
    require "../config.php";
    require "../common.php";
        try {
            $connection = new PDO($dsn, $username, $password, $options);

            $sql = "SELECT * FROM Course;";

            $statement = $connection->prepare($sql);
            $statement->execute();

            $result = $statement->fetchAll();

            // $sql2 = "SELECT * FROM Assignment
            //         WHERE due_date <= CURRENT_DATE + INTERVAL 3 DAY";
            //
            // $statement1 = $connection->prepare($sql2);
            // $statement1->execute();
            // $alerts = $statement1->fetchAll();


        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    ?>
    <?php include "templates/header.php"; ?>

      <table>
          <thead>
              <tr>
                  <th>Course</th>
                  <th>Professor</th>
                  <th>Semester</th>
                  <th>Credit Hours</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($result as $row) : ?>
                  <tr>
                      <td><?php echo escape($row["name"]); ?></td>
                      <td><?php echo escape($row["professor"]); ?></td>
                      <td><?php echo escape($row["semester"]); ?></td>
                      <td><?php echo escape($row["creditHours"]); ?></td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>

    <br></br>
    <ul>
      <button type="button" class="btn btn-primary" onclick="window.location.href = 'update_class.php';">Manage Classes</button>
      <button type="button" class="btn btn-warning" onclick="window.location.href = 'gpa_visualization.php';">Progress Chart</button>
    <?php include "templates/footer.php"; ?>

  </body>
</html>
