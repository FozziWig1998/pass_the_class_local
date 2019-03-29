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
      "CRN"        => $_POST['CRN'],
      "creditHours" => $_POST['creditHours'],
      "semester"  => $_POST['semester'],
      "professor"     => $_POST['professor']
    ];
    $sql = "UPDATE Course
            SET CRN = :CRN,
              creditHours = :creditHours,
              semester = :semester,
              professor = :professor
            WHERE CRN = :CRN";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['CRN'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['CRN'];
    $sql = "SELECT * FROM Course WHERE CRN = :CRN";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':CRN', $id);
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
	<blockquote><?php echo escape($_POST['CRN']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'CRN' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
