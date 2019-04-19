<?php

require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
    try  {
      $connection = new PDO($dsn, $username, $password, $options);

      $netId = "parthgp2";
      $course_name = "CS 241";

      $sql = "
            SELECT time_stamp, grade
            FROM Class_Grade_Log
            WHERE netId = :netId AND course_name = :course_name;
      ";

      $statement = $connection->prepare($sql);

      $statement->bindValue(':netId', $netId);
      $statement->bindValue(':course_name', $course_name);

      $statement->execute();
      // $result = $statement->fetchAll();

        $filelocation = '../assests/';
        $filename = 'data.csv';
        $file_export = $filelocation.$filename;

        $data = fopen($file_export, 'w');

        $csv_fields = array();

        $csv_fields[] = 'time_stamp';
        $csv_fields[] = 'grade';

        fputcsv($data, $csv_fields);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($data, $row);
        }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<h2>Grade Progression in Specified Course</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="netId">netId</label>
  <input type="text" id="netId" name="netId">
  <label for="netId">Course Name</label>
  <input type="text" id="course_name" name="course_name">
  <input type="submit" name="submit" value="Submit">

  <a href="simple-graph.html" class="btn btn-default">View Graph</a>
  <a href="index.php" class="btn btn-default">Back to Home</a>
</form>
