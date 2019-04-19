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
    $assignment_name = $_POST['assignment_name'];
    $sql = "DELETE
            FROM Category_Assignment
            WHERE assignment_name IN (
                                      SELECT assignment_name
                                      FROM Assignment
                                      WHERE id = :id);

            DELETE
            FROM Assignment
            WHERE id = :id; ";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':assignment_name', $assignment_name);

    $statement->execute();
    $success = "Assignment successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
if (isset($_GET['assignment_name'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $assignment_name = $_GET['assignment_name'];
        $sql = "SELECT * FROM Assignment WHERE assignment_name = :assignment_name";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':assignment_name', $assignment_name);
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

<h2>Delete Assignments</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Percentage</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["assignment_name"]); ?></td>
        <td><?php echo escape($row["percentage"]); ?></td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>
<?php require "templates/footer.php"; ?>
