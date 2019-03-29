<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
      FROM course
      WHERE CRN = :CRN";

    $location = $_POST['CRN'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':CRN', $location, PDO::PARAM_STR);
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
             <th>CRN</th>
             <th>Credit Hours</th>
             <th>Semester</th>
             <th>Professor</th>
           </tr>
         </thead>
         <tbody>
     <?php foreach ($result as $row) { ?>
         <tr>
           <td><?php echo escape($row["CRN"]); ?></td>
           <td><?php echo escape($row["creditHours"]); ?></td>
           <td><?php echo escape($row["semester"]); ?></td>
           <td><?php echo escape($row["professor"]); ?></td>
         </tr>
       <?php } ?>
         </tbody>
     </table>
     <?php } else { ?>
       <blockquote>No results found for <?php echo escape($_POST['CRN']); ?>.</blockquote>
     <?php }
   } ?>




<h2>Find Class based on CRN</h2>

    <form method="post">
    	<label for="CRN">CRN</label>
    	<input type="text" id="CRN" name="CRN">
    	<input type="submit" name="submit" value="View Results">
    </form>

    <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
