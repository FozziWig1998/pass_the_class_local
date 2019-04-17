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


    $assignment_name = $_POST['assignment_name'];
    $course_name = $_POST['course_name'];
    $percentage = $_POST['percentage'];
    $category_name = $_POST['category_name'];

    $sql = "
      INSERT INTO Assignment (assignment_name, percentage) VALUES (:assignment_name, :percentage);
      INSERT INTO Category_Assignment (assignment_name, category_name) VALUES (:assignment_name, :category_name);
      ";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':assignment_name', $assignment_name);
    $statement->bindValue(':course_name', $course_name);
    $statement->bindValue(':percentage', $percentage);
    $statement->bindValue(':category_name', $category_name);

    $statement->execute();


      // $connection = null;
  /*
    $new_user = array(
      "name"         => $_POST['name'],
      "course_name"   => $_POST['course_name'],
      "percentage"   => $_POST['percentage']
    );
    $sql1 = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Assignment",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    $statement = $connection->prepare($sql1);


    $join_table = array(
      "name"   => $_POST['assignment_name'],
      "category_name"   => $_POST['category_name'],
    );
    $sql2 = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Course_Category",
      implode(", ", array_keys($join_table)),
      ":" . implode(", :", array_keys($join_table))
    );


    $statement = $connection->prepare($sql2);
    $statement->execute($new_user);
    $statement->execute($join_table);*/


  } catch(PDOException $error) {
      echo $sql . "<br>" . $course_name . "<br>" . $assignment_name ."<br>" . $percentage ."<br>" . $category_name . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['assignment_name']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add an Assignment</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="assignment_name">Name</label>
    <input type="text" name="assignment_name" id="assignment_name">
    <label for="percentage">Percentage</label>
    <input type="number" name="percentage" min="0" value="0" step="0.05" id="percentage">
    <label for="Category">Category</label>
    <input type="text" name="category_name" id="category_name">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
