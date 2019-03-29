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
    $sql = "DELETE FROM Course WHERE CRN = :CRN";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':CRN', $id);
    $statement->execute();
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
        <th>CRN</th>
        <th>Semester</th>
        <th>Credit Hours</th>
        <th>Professor</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["CRN"]); ?></td>
        <td><?php echo escape($row["semester"]); ?></td>
        <td><?php echo escape($row["creditHours"]); ?></td>
        <td><?php echo escape($row["professor"]); ?></td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["CRN"]); ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
