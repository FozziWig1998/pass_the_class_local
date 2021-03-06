<?php
/**
 * Function to query information based on
 * a parameter
 *
 */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT *
            FROM Student
            WHERE netId = :netId";
    $location = $_POST['netId'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':netId', $location, PDO::PARAM_STR);
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
    <h3>Results</h3>

    <table>
      <thead>
        <tr>
          <th>Net ID</th>
          <th>Year</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["netId"]); ?></td>
          <td><?php echo escape($row["curr_year"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['netId']); ?>.</blockquote>
    <?php }
} ?>

<h3>Find Student based on netId</h3>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="netId">netId</label>
  <input type="text" id="netId" name="netId">
  <input type="submit" name="submit" value="View Results">
</form>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
