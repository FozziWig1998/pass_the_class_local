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
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $name = $_POST['name'];
    $netId = $_POST['netId'];

    $sql = "SELECT Student_Class.netId, Course.professor
            FROM Course
            INNER JOIN Student_Class ON Course.name = Student_Class.name
            WHERE Student_Class.netId <> :netId AND Course.name = :name";
    $statement = $connection->prepare($sql);

    $statement->bindParam(':name', $name);
    $statement->bindParam(':netId', $netId);
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

    <br></br>
    <h3>Study Buddies:</h3>

    <table>
      <thead>
        <tr>
          <th>Net Id</th>
          <th>Professor</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["netId"]); ?></td>
          <td><?php echo escape($row["professor"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No buddies in <?php echo escape($_POST['name']); ?> :(</blockquote>
    <?php }
} ?>

<br></br>
<h4>Find Study Buddies based on Course</h4>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="name">Course Name</label>
  <input type="text" id="name" name="name">
  <label for="netId">Your Net Id</label>
  <input type="text" id="netId" name="netId">
  <input type="submit" name="submit" value="View Results">
</form>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
