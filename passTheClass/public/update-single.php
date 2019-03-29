<?php
require "config.php";
require "index.php";

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $usernamem, $password, $options)

        $new_course = [
            $id =>$_POST['id'];
            $crn =>$_POST['CRN'];
            $professor =>$_POST['professor'];
            $creditHours =>$_POST['creditHours'];
        ];

        $sql = "UPDATE courses
                SET id = :id,
                  firstname = :firstname,
                  lastname = :lastname,
                  email = :email,
                  age = :age,
                  location = :location,
                  date = :date
                WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->execute($new_course);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET["id"]) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['id'];

        $sql = "SELECT * FROM courses WHERE CRN = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Something has gone wrong";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<h2>Edit a course</h2>

<form method="post">
  <?php foreach ($course as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>"
          value="<?php echo escape($value); ?>"><?php echo ($key === 'id' ? 'readonly' : null); ?>>
  <?php endforeach; ?>
  <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
