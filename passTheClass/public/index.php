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
    if (isset($_POST['submit'])) {
        try {
            $connection = new PDO($dsn, $username, $password, $options);

            $netId = $_POST['netId'];

            $sql = "
            SELECT demon.course_name AS course_name, (toast/satan)*100 AS grade
                    FROM (	SELECT Assignment.course_name, SUM(percentage*0.01*calc) AS toast
                    		FROM ( SELECT creambang.course_name, creambang.category_name, weightage, weightage/COUNT(creambang.assignment_name) AS calc
                    				FROM Category JOIN (SELECT * FROM Assignment WHERE netId = :netId) AS creambang ON Category.name = creambang.category_name
                    					AND Category.course_name = creambang.course_name
                    				GROUP BY creambang.category_name, creambang.course_name) AS table1,
                    			Assignment
                    		WHERE Assignment.netId = :netId
                        AND Assignment.category_name = table1.category_name AND Assignment.course_name = table1.course_name
                    		GROUP BY Assignment.course_name ) AS bread,
                    	(	SELECT dead.course_name, SUM(weightage) AS satan
                    		FROM (	SELECT grape.course_name, grape.category_name, weightage
                    				FROM Category JOIN (SELECT * FROM Assignment WHERE netId = :netId) AS grape ON Category.name = grape.category_name
                    						AND Category.course_name = grape.course_name
                    				GROUP BY grape.category_name, grape.course_name ) AS dead
                    		GROUP BY dead.course_name) AS demon
                    WHERE bread.course_name = demon.course_name
                    GROUP BY demon.course_name;


            ";

            $statement = $connection->prepare($sql);
            $statement->bindValue(':netId', $netId);
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
      }
    ?>
    <?php include "templates/header.php"; ?>

      <table>
          <thead>
              <tr>
                  <th>Course</th>
                  <th>Grade</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($result as $row) : ?>
                  <tr>
                      <td><?php echo escape($row["course_name"]); ?></td>
                      <td><?php echo escape($row["grade"]); ?></td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>

    <br></br>
    <ul>



    <h3>View Grades For:</h3>

    <form method="post">
      <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
      <label for="netId">Net Id</label>
      <input type="text" name="netId" id="netId">
      <input type="submit" name="submit" value="Submit">
    </form>

    <button type="button" class="btn btn-primary" onclick="window.location.href = 'update_class.php';">Manage Classes</button>
    <button type="button" class="btn btn-warning" onclick="window.location.href = 'gpa_visualization.php';">Progress Chart</button>
  <?php include "templates/footer.php"; ?>

  </body>
</html>
