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
            WHERE name = :name AND course_name = :course_CRN";
    $location = $_POST['name'];
    $course_crn = $_POST['course_CRN'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':name', $location, PDO::PARAM_STR);
    $statement->bindParam(':course_CRN', $course_crn, PDO::PARAM_STR);
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
          <th>Course CRN</th>
          <th>Weightage</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["name"]); ?></td>
          <td><?php echo escape($row["course_CRN"]); ?></td>
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
  <label for="name">Course CRN</label>
  <input type="number" id="course_CRN" name="course_CRN">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
