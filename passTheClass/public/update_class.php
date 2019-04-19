<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        // $course_name = $_POST['course_name'];
        // $category_name = $_POST['category_name'];
        $netId = $_POST['netId'];

        $sql = "SELECT *
                FROM Course
                WHERE name IN (SELECT name
                                FROM Student_Class
                                WHERE netId = :netId
                                );";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':netId', $netId);

        $statement->execute();

        $result = $statement->fetchAll();
      } catch (PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
      }
    }
// } else {
//     echo "Something went wrong!";
//     exit;
// }
?>

<?php require "templates/header.php" ?>

<h2>Update Course</h2>

<table>
    <thead>
        <tr>
            <th>Course Name</th>
            <th>Professor</th>
            <th>Semester</th>
            <th>Credit Hours</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["name"]); ?></td>
                <td><?php echo escape($row["professor"]); ?></td>
                <td><?php echo escape($row["semester"]); ?></td>
                <td><?php echo escape($row["creditHours"]); ?></td>
                <td><a href="update-single_class.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
                <td><a href="delete_class.php?id=<?php echo escape($row["id"]); ?>">Delete</a></td>
                <td><a href="update_category.php?course_name=<?php echo escape($row["name"]);?>">View Categories</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<h2>View Courses For:</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="Net Id">Net Id</label>
  <input type="text" name="netId" id="netId">
  <input type="submit" name="submit" value="Submit">
</form>


<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_assignments.php';">Add Assignment</button>


<?php require "templates/footer.php"; ?>
