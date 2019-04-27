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

    $name = $_POST['course_name'];
    $netId = $_POST['netId'];
    // $netId = $_GET["netId"]
    $sql = "DELETE FROM Student_Class WHERE netId = :netId AND name = :name;
            DELETE FROM Category_Assignment WHERE assignment_name =(SELECT assignment_name FROM Assignment WHERE course_name = :name);
            DELETE FROM Assignment WHERE course_name = :name;
            DELETE FROM Class_Grade_Log WHERE course_name = :name;
    ";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':netId', $netId);
    $statement->bindValue(':name', $name);

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
?>


<?php
if (isset($_GET['netId'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $netId = $_GET['netId'];
        $sql = "SELECT * FROM Course WHERE name IN (SELECT name
                                                          FROM Student_Class
                                                          WHERE netId = :netId)";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':netId', $netId);
        $statement->execute();

        $result = $statement->fetchAll();
      } catch (PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
      }
  } else {
  echo "Something went wrong!";
  exit;
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


<h2>Delete Course</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="course_name">Course Name</label>
  <input type="text" id="course_name" name="course_name">
  <label for="NetId">NetId</label>
  <input type="text" id="NetId" name="NetId">
  <input type="submit" name="submit" value="View Results">
</form>


<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>



<?php require "templates/footer.php"; ?>
