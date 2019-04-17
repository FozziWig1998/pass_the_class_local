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
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $name = $_POST['name'];
    $course_name = $_POST['course_name'];
    $weightage = $_POST['weightage'];

    $sql = "
    INSERT INTO Category (name, weightage) VALUES (:name, :weightage);
    INSERT INTO Course_Category (course_name, category_name) VALUES (:course_name, :name);
    ";

    $statement = $connection->prepare($sql);

    $statement->bindValue(':name', name);
    $statement->bindValue(':course_name', $course_name);
    $statement->bindValue(':weightage', $weightage);

    $statement->execute();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['name']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a Category</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">
    <label for="weightage">Weightage</label>
    <input type="number" name="weightage" min="0" value="0" step="0.05" id="weightage">
    <label for="course_name">Course Name</label>
    <input type="text" name="course_name" id="course_name">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
