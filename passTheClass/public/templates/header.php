<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Pass the Class</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body class="main">
    <ul class="nav nav-tabs">
     <li>
       <a href="create_student.php"><strong>Create a Student</strong></a>
     </li>
      <li>
        <a href="read_class.php"><strong>Find a Class</strong></a>
      </li>
      <li>
         <a href="read_student.php"><strong>Find a Student</strong></a>
      </li>
      <li>
        <a href="update_student.php"><strong>Update a Student</strong></a>
      </li>
      <li>
        <a href="delete_student.php"><strong>Delete a Student</strong></a>
      </li>
    </ul>

    <h1>Pass the Class</h1>
    <?php
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql2 = "SELECT * FROM Assignment
                WHERE due_date <= CURRENT_DATE + INTERVAL 3 DAY
                    AND due_date > CURRENT_DATE";

        $statement1 = $connection->prepare($sql2);
        $statement1->execute();
        $alerts = $statement1->fetchAll();


    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    ?>

    <div class="sidenav">
      <table>
          <thead>
            <h5>Upcoming Assignments</h5>
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
    </div>
  </body>

  <style>
    .sidenav {
    height: 100%; /* Full-height: remove this if you want "auto" height */
    width: 200px; /* Set the width of the sidebar */
    position: fixed; /* Fixed Sidebar (stay in place on scroll) */
    z-index: 1; /* Stay on top */
    top: 0; /* Stay at the top */
    left: 0;
    background-color: #7caeff; /* Black */
    overflow-x: hidden; /* Disable horizontal scroll */
    padding-top: 20px;
    padding-left: 10px;
    padding-right: 10px;
  }

  /* Style page content */
  .main {
    margin-left: 200px; /* Same as the width of the sidebar */
    padding: 0px 10px;
  }
  </style>

</html>
