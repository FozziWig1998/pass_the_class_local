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
    $due_date = $_POST['due_date'];
    $netId = $_POST['netId'];


    $sql = "
      INSERT INTO Assignment (assignment_name, percentage, due_date, category_name, course_name, netId)
      VALUES (:assignment_name, :percentage, :due_date, :category_name, :course_name, :netId);

      INSERT INTO Category_Assignment (assignment_name, category_name) VALUES (:assignment_name, :category_name);
      ";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':assignment_name', $assignment_name);
    $statement->bindValue(':course_name', $course_name);
    $statement->bindValue(':percentage', $percentage);
    $statement->bindValue(':category_name', $category_name);
    $statement->bindValue(':due_date', $due_date);
    $statement->bindParam(':netId', $netId);

    $statement->execute();


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
    <label for="DueDate">Due Date</label>
    <input type="date" name="due_date" id="due_date">
    <label for="Course">Course</label>
    <input type="text" name="course_name" id="course_name">
    <label for="NetId">NetId</label>
    <input type="text" name="netId" id="netId">
    <input type="submit" name="submit" value="Submit">
  </form>

  <button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
