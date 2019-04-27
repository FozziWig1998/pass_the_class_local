<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $course_name = $_POST['course_name'];
        // $category_name = $_POST['category_name'];
        $netId = $_POST['netId'];

        $sql = "SELECT *
                FROM Assignment
                WHERE course_name = :course_name AND netId = :netId;
                ";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':course_name', $course_name);
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

<h2>Update Assignment</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Percentage</th>
            <th>Due Date</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["assignment_name"]); ?></td>
                <td><?php echo escape($row["percentage"]); ?></td>
                <td><?php echo escape($row["due_date"]); ?></td>
                <td><?php echo escape($row["category_name"]); ?></td>
                <td><a href="update-single_assignments.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
                <td><a href="delete_assignments.php?id=<?php echo escape($row["id"]); ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>View Assignments For:</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="Course Name">Course Name</label>
  <input type="text" name="course_name" id="course_name">
  <label for="Net Id">Net Id</label>
  <input type="text" name="netId" id="netId">
  <input type="submit" name="submit" value="Submit">
</form>


<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_assignments.php';">Add Assignment</button>


<?php require "templates/footer.php"; ?>
