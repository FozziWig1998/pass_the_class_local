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
    $professor = $_POST['professor'];
    $semester = $_POST['semester'];
    $creditHours = $_POST['creditHours'];
    $netId = $_POST['netId'];

    $sql = "
      INSERT IGNORE INTO Course (name, professor, semester, creditHours)
      VALUES (:name, :professor, :semester, :creditHours);


      INSERT INTO Student_Class (netId, name) VALUES (:netId, :name);
      ";

    $statement = $connection->prepare($sql);

    $statement->bindValue(':name', $name);
    $statement->bindValue(':professor', $professor);
    $statement->bindValue(':semester', $semester);
    $statement->bindValue(':creditHours', $creditHours);
    $statement->bindValue(':netId', $netId);


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

  <h2>Add a Class</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="name">Course Name</label>
    <input type="text" name="name" id="name">
    <label for="semester">Semester</label>
    <input type="text" name="semester" id="semester">
    <label for="professor">Professor</label>
    <input type="text" name="professor" id="professor">
    <label for="creditHours">Credit Hours</label>
    <input type="number" name="creditHours" id="creditHours">
    <label for="netId">Net Id</label>
    <input type="text" name="netId" id="netId">
    <input type="submit" name="submit" value="Submit">
  </form>

  <button type="button" class="btn btn-primary" onclick="window.location.href = 'update_class.php';">View Classes</button>
  <button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
