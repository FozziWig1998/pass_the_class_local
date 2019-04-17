<?php
require "../config.php";
require "../common.php";
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM Assignment";

        $statement = $connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
?>

<?php require "templates/header.php" ?>

<h2>Update Assignment</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Course</th>
            <th>Percentage</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["assignment_name"]); ?></td>
                <td><?php echo escape($row["course_name"]); ?></td>
                <td><?php echo escape($row["percentage"]); ?></td>
                <td><a href="update-single_assignments.php?assignment_name=<?php echo escape($row["assignment_name"]); ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
