<?php
/**
 * Use an HTML form to edit an entry in the
 * students table.
 *
 */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "netId"   => $_POST['netId'],
      "curr_year"    => $_POST['curr_year'],
    ];
    $sql = "UPDATE Student
            SET netId = :netId,
                curr_year = :curr_year
            WHERE netId = :netId";
  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
if (isset($_GET['netId'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['netId'];
    $sql = "SELECT * FROM Student WHERE netId = :netId";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':netId', $id);
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
	<blockquote><?php echo escape($_POST['netId']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a Student</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'netId' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
