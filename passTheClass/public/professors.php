<?php
/**
 * Delete a Student
 */
require "../config.php";
require "../common.php";
if (isset($_POST["submit"])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $netId = $_POST['netId'];
    $sql = "SELECT professor AS prof, COUNT(*) AS ct
            FROM (SELECT *
                  FROM Course
                  WHERE name IN (
								SELECT name
                                FROM Student_Class
                                WHERE netId = :netId)) as Filter
            GROUP BY Filter.professor;";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':netId', $netId);
    $statement->execute();
    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

<h2>Professor Frequency</h2>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>
          <th>Professor</th>
          <th>Count</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["prof"]); ?></td>
          <td><?php echo escape($row["ct"]); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['prof']); ?>.</blockquote>
    <?php }
} ?>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="netid">netId</label>
  <input type="text" id="netId" name="netId">
  <input type="submit" name="submit" value="View Results">
</form>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
