<?php
    try {
        require "config.php";
        require "common.php";

        $sql = "SELECT * FROM users";

        $statement = $connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
?>

<?php require "templates/header.php" ?>

<h2>Update course</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>CRN</th>
            <th>Professor</th>
            <th>Semester</th>
            <th>Credit Hours</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["id"]); ?></td>
                <td><?php echo escape($row["crn"]); ?></td>
                <td><?php echo escape($row["professor"]); ?></td>
                <td><?php echo escape($row["semester"]); ?></td>
                <td><?php echo escape($row["creditHours"]); ?></td>
                <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
