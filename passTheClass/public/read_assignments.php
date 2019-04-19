<?php
/**
 * Function to query information based on
 * a parameter: in this case, location.
 *
 */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT *
            FROM Assignment
            WHERE assignment_name = :name AND course_name = :course_name";
    $location = $_POST['name'];
    course_name = $_POST['course_name'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':name', $location, PDO::PARAM_STR);
    $statement->bindParam(':course_name', $course_name, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Course Name</th>
          <th>Weightage</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["name"]); ?></td>
          <td><?php echo escape($row["course_name"]); ?></td>
          <td><?php echo escape($row["percentage"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['name']); ?>.</blockquote>
    <?php }
} ?>

<h2>Find Assigment based on Name</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="name">Name</label>
  <input type="text" id="name" name="name">
  <label for="name">Course Name</label>
  <input type="text" id="course_name" name="course_name">
  <label for="name">NetId</label>
  <input type="text" id="netId" name="netId">
  <input type="submit" name="submit" value="View Results">
</form>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
