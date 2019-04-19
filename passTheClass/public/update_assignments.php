<?php
require "../config.php";
require "../common.php";

if (isset($_GET['category_name'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $category_name = $_GET['category_name'];
        $sql = "SELECT * FROM Assignment WHERE assignment_name IN (
          SELECT assignment_name FROM Category_Assignment WHERE category_name = :category_name
        )";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':category_name', $category_name);
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

<h2>Update Assignment</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Percentage</th>
            <th>Due Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["assignment_name"]); ?></td>
                <td><?php echo escape($row["percentage"]); ?></td>
                <td><?php echo escape($row["due_date"]); ?></td>
                <td><a href="update-single_assignments.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
                <td><a href="delete_assignments.php?assignment_name=<?php echo escape($row["assignment_name"]); ?>">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_assignments.php';">Add Assignment</button>


<?php require "templates/footer.php"; ?>
