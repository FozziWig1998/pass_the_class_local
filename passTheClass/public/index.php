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


    <!-- <br></br>
    <div class="sidenav">
      <table>
          <thead>
            <h5>Upcomming Assignments</h5>
              <tr>
                  <th>Name</th>
                  <th>Due Date</th>
              </tr>
          </thead>
          <tbody>

              <?php foreach ($alerts as $row) : ?>
                  <tr>
                      <td><?php echo escape($row["assignment_name"]); ?></td>
                      <td><?php echo escape($row["due_date"]); ?></td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
    </div> -->
    <!-- <script>
    alert("Hello! I am an alert box!");
    </script> -->

    <ul>
      <button type="button" class="btn btn-primary" onclick="window.location.href = 'update_class.php';">Manage Classes</button>
      <a href="gpa_visualization.php"><strong>Progress Chart</strong></a>

      <!-- <li>
        <a href="create_class.php"><strong>Add a Class</strong></a>
      </li> -->
      <!-- <li>
        <a href="create_assignments.php"><strong>Add an Assignment</strong></a>
      </li>
      <li>
        <a href="create_category.php"><strong>Add a Category</strong></a>
      </li> -->
      <!-- <li>
        <a href="read_class.php"><strong>Find a Class</strong></a>
      </li> -->
      <!-- <li>
        <a href="read_assignments.php"><strong>Find an Assignment</strong></a>
      </li> -->
      <!-- <li>
        <a href="read_category.php"><strong>Find a Category</strong></a>
      </li> -->
      <!-- <li>
        <a href="update_class.php"><strong>Edit a Class</strong></a>
      </li> -->
      <!-- <li>
        <a href="update_assignments.php"><strong>Edit an Assignment</strong></a>
      </li>
      <li>
        <a href="update_category.php"><strong>Edit a Category</strong></a>
      </li> -->
      <!-- <li>
        <a href="delete_class.php"><strong>Delete a Class</strong></a>
      </li> -->
      <!-- <li>
        <a href="delete_assignments.php"><strong>Delete an Assignment</strong></a>
      </li>
      <li>
        <a href="delete_category.php"><strong>Delete a Category</strong></a>
      </li>
      <li>
        <a href="create_student.php"><strong>Add a Student</strong></a>
      </li> -->
      <!-- <li>
         <a href="read_student.php"><strong>Find a Student</strong></a>
      </li>
      <li>
        <a href="update_student.php"><strong>Update a Student</strong></a>
      </li>
      <li>
        <a href="delete_student.php"><strong>Delete a Student</strong></a>
      </li>
      <li>
        <a href="gpa_visualization.php"><strong>GOOD SHIT</strong></a>
      </li>


        <br></br>
      <li>
        <a href="professors.php"><strong>Get all Professors</strong></a>
      </li>
      <li>
        <a href="study_buddies.php"><strong>Find Study Buddies in your Classes!</strong></a>
      </li>
    </ul>

    <?php include "templates/footer.php"; ?>

  </body>
</html>
