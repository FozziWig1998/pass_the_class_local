<?php
/**
 * Delete a user
 */
require "../config.php";
require "../common.php";
$success = null;
if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_POST["submit"];
    $sql = "DELETE FROM Course_Category WHERE course_name = (SELECT name FROM Course WHERE id = :id);
            DELETE FROM Category WHERE course_name = (SELECT name FROM Course WHERE id = :id);
            DELETE FROM Student_Class WHERE name = (SELECT name FROM Course WHERE id = :id);
            DELETE FROM Class_Grade_Log WHERE course_name = (SELECT name FROM Course WHERE id = :id);
            DELETE FROM Category_Assignment WHERE assignment_name = (SELECT assignment_name WHERE course_name = (SELECT name FROM Course WHERE id = :id));
            DELETE FROM Assignment WHERE course_name = (SELECT name FROM Course WHERE id = :id);
            DELETE FROM Course WHERE id = :id;
    ";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    // $sql1 = "SELECT name FROM Course WHERE id = :id";
    // $statement = $connection->prepare($sql);
    // $statement->bindValue(':id', $id);
    // $statement->execute();
    $result = $statement->fetchALL();


    $success = "Course successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
try {
  $connection = new PDO($dsn, $username, $password, $options);
  $sql = "SELECT * FROM Course";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete Courses</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
        <th>Course Name</th>
        <th>Semester</th>
        <th>Credit Hours</th>
        <th>Professor</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["name"]); ?></td>
        <td><?php echo escape($row["semester"]); ?></td>
        <td><?php echo escape($row["creditHours"]); ?></td>
        <td><?php echo escape($row["professor"]); ?></td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
