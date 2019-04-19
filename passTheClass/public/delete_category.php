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
    $sql = "DELETE FROM Course_Category WHERE category_name = (SELECT name FROM Category WHERE id = :id);
            DELETE FROM Category_Assignment WHERE category_name = (SELECT name FROM Category WHERE id = :id);
            DELETE FROM Assignment WHERE category_name = (SELECT name FROM Category WHERE id = :id);
            DELETE FROM Category WHERE id = :id;";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $success = "Category successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['id'];
        $sql = "SELECT * FROM Category WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
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

<h2>Delete Category</h2>

<?php if ($success) echo $success; ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Weightage</th>
        <th>Course</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["name"]); ?></td>
        <td><?php echo escape($row["weightage"]); ?></td>
        <td><?php echo escape($row["course_name"]); ?></td>
        <td><button type="submit" name="submit" value="<?php echo escape($row["id"]); ?>">Delete</button></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</form>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
