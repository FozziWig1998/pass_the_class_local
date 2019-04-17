<?php
/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "assignment_name"       => $_POST['assignment_name'],
      "course_name"            => $_POST['course_name'],
      "percentage"            => $_POST['percentage'],
    ];
    $sql = "UPDATE Assignment
            SET assignment_name = :assignment_name,
              course_name = :course_name,
              percentage = :percentage
            WHERE assignment_name = :assignment_name AND course_name = :course_name";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['assignment_name'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['assignment_name'];
    $sql = "SELECT * FROM Assignment WHERE assignment_name = :assignment_name";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':assignment_name', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['assignment_name']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit an Assignment</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'name' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
