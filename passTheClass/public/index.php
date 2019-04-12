<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Pass The Class</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>
    <h1>Pass the Class</h1>

    <?php include "templates/header.php"; ?>


    <?php
    require "../config.php";
    require "../common.php";
        try {
            $connection = new PDO($dsn, $username, $password, $options);

            $sql = "SELECT * FROM Course";

            $statement = $connection->prepare($sql);
            $statement->execute();

            $result = $statement->fetchAll();
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    ?>

    <table>
        <thead>
            <tr>
                <th>CRN</th>
                <th>Professor</th>
                <th>Semester</th>
                <th>Credit Hours</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) : ?>
                <tr>
                    <td><?php echo escape($row["CRN"]); ?></td>
                    <td><?php echo escape($row["professor"]); ?></td>
                    <td><?php echo escape($row["semester"]); ?></td>
                    <td><?php echo escape($row["creditHours"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <ul>
      <li>
        <a href="create_class.php"><strong>Add a Class</strong></a>
      </li>
      <li>
        <a href="create_assignments.php"><strong>Add an Assignment</strong></a>
      </li>
      <li>
        <a href="create_category.php"><strong>Add a Category</strong></a>
      </li>
      <li>
        <a href="read_class.php"><strong>Find a Class</strong></a>
      </li>
      <li>
        <a href="read_assignments.php"><strong>Find an Assignment</strong></a>
      </li>
      <li>
        <a href="read_category.php"><strong>Find a Category</strong></a>
      </li>
      <li>
        <a href="update_class.php"><strong>Edit a Class</strong></a>
      </li>
      <li>
        <a href="update_assignments.php"><strong>Edit an Assignment</strong></a>
      </li>
      <li>
        <a href="update_category.php"><strong>Edit a Category</strong></a>
      </li>
      <li>
        <a href="delete_class.php"><strong>Delete a Class</strong></a>
      </li>
      <li>
        <a href="delete_assignments.php"><strong>Delete an Assignment</strong></a>
      </li>
      <li>
        <a href="delete_category.php"><strong>Delete a Category</strong></a>
      </li>
    </ul>

    <?php include "templates/footer.php"; ?>

  </body>
</html>
