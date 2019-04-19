<?php
require "../config.php";
require "../common.php";

if (isset($_GET['course_name'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $course_name = $_GET['course_name'];
        $sql = "SELECT * FROM Category WHERE name IN (
          SELECT category_name FROM Course_Category WHERE course_name = :course_name
        )";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':course_name', $course_name);
        $statement->execute();

        $result = $statement->fetchAll();
      } catch (PDOException $e) {
          echo $sql . "<br>" . $e->getMessage();
      }
} else {
    echo "Something went wrong!";
    exit;
}


?>

<?php require "templates/header.php" ?>

<h2>Update Category</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Weightage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["name"]); ?></td>
                <td><?php echo escape($row["weightage"]); ?></td>
                <td><a href="update-single_category.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
                <td><a href="delete_category.php?id=<?php echo escape($row["id"]); ?>">Delete</a></td>
<<<<<<< HEAD
                <a href="update_assignments.php?">View Assignments</a>
=======

>>>>>>> aa071bddf28f4c09bdaf9a33d9018a73c72a7f81

            </tr>
        <?php endforeach; ?>
        <a href="update_assignments.php?">View Assignments</a>
    </tbody>
</table>
<!-- <h2>View Assignments For:</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="Course Name">Course Name</label>
  <input type="text" name="course_name" id="course_name">
  <label for="Category Name">Category Name</label>
  <input type="text" name="category_name" id="category_name">
  <label for="Net Id">Net Id</label>
  <input type="text" name="netId" id="netId">
  <a href="update_assignments.php?id=<?php echo escape($row["id"]); ?>">View Assignments</a>
</form> -->

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_category.php';">Add Categories</button>
<<<<<<< HEAD
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_assignments.php';">Add Assignments</button>
=======
<<<<<<< HEAD
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_assignments.php';">Add Assignments</button>
=======
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_assignments.php';">Add Assignment</button>
>>>>>>> b55c56c3a4fd94b5d2bfcbc4480a3a523811f3dd
>>>>>>> aa071bddf28f4c09bdaf9a33d9018a73c72a7f81


<?php require "templates/footer.php"; ?>
