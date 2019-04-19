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
                <td><a href="update_assignments.php?category_name=<?php echo escape($row["name"]); ?>">View Assignments</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_category.php';">Add Categories</button>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_assignments.php';">Add Assignment</button>


<?php require "templates/footer.php"; ?>
