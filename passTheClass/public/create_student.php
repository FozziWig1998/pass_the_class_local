<?php
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    $new_user = array(
      "netId" => $_POST['netId'],
      "year"  => $_POST['year'],
    );
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Student",
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
<?php include "templates/header.php"; ?>
        <?php if (isset($_POST['submit']) && $statement) : ?>
        <blockquote><?php echo escape($_POST['netId']); ?> successfully added.</blockquote>
        <?php endif; ?>

        <h2>Add a Student</h2>

    <form method="post">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
        <label for="netId">netId</label>
        <input type="text" name="netId" id="netId">
        <label for="year">year</label>
        <input type="number" name="year" min="1" value="1" step="1" id="year">
        <input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Back to home</a>

    <?php include "templates/footer.php"; ?>
