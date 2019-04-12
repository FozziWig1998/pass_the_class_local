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
      "CRN" => $_POST['CRN'],
      "semester"  => $_POST['semester'],
      "professor"     => $_POST['professor'],
      "creditHours"       => $_POST['creditHours']
    );
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Course",
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
    <blockquote><?php echo escape($_POST['CRN']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a Class</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="CRN">CRN</label>
    <input type="number" name="CRN" id="CRN">
    <label for="semester">Semester</label>
    <input type="text" name="semester" id="semester">
    <label for="professor">Professor</label>
    <input type="text" name="professor" id="professor">
    <label for="creditHours">Credit Hours</label>
    <input type="number" name="creditHours" id="creditHours">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
