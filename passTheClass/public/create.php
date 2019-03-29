<?php /*add a new class page... this will be used to add a new class to the database */

if (isset($_POST['submit'])) {
  require "../common.php";
  require "../config.php";

  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $new_course = array(
      'CRN' => $_POST['CRN'],
      'creditHours' => $_POST['creditHours'],
      'semester' => $_POST['semester'],
      'professor' => $_POST['professor']
     );

     $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "Course",
        implode(", ", array_keys($new_course)),
                ":" . implode(", :", array_keys($new_course))
     );

     $statement = $connection->prepare($sql);
     $statement->execute($new_course);

  } catch(PDOException $error) {
      echo $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
   <blockquote><?php
   echo $_POST['CRN'];
   echo " ";
   echo $_POST['creditHours'];
   echo " ";
   echo $_POST['semester'];
   echo " ";
   echo $_POST['professor'];
   echo " ";
   ?> successfully added.</blockquote>
<?php }

 else if (isset($_POST['submit'])) { ?>
   <blockquote><?php echo $_POST['CRN']; ?> not added.</blockquote>
<?php } ?>




<h2>Add a course</h2>

<form method="post">
	<label for="CRN">Course CRN</label>
	<input type="number" name="CRN" id="CRN">

	<label for="creditHours">Credit Hours</label>
	<input type="number" name="creditHours" id="creditHours">

	<label for="semester">Semester</label>
	<input type="text" name="semester" id="semester">

	<label for="professor">Professor</label>
	<input type="text" name="professor" id="professor">

  <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>
