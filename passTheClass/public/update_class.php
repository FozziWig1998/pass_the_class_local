<?php
require "../config.php";
require "../common.php";
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM Course";

        $statement = $connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
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

<br></br>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'create_class.php';">Add Classes</button>
<button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>



<?php require "templates/footer.php"; ?>
