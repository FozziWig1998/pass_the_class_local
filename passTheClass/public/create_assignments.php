<?php
/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_user = array(
      "name"         => $_POST['name'],
      "course_CRN"   => $_POST['course_CRN'],
      "percentage"   => $_POST['percentage']
    );
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Assignment",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['name']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add an Assignment</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="Name">Name</label>
    <input type="text" name="name" id="name">
    <label for="course_CRN">Course CRN</label>
    <input type="number" name="course_CRN" id="course_CRN">
    <label for="percentage">Percentage</label>
    <input type="number" name="percentage" min="0" value="0" step="0.1" id="percentage">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
