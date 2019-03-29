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

<h2>Update course</h2>

<table>
    <thead>
        <tr>
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
                <td><?php echo escape($row["CRN"]); ?></td>
                <td><?php echo escape($row["professor"]); ?></td>
                <td><?php echo escape($row["semester"]); ?></td>
                <td><?php echo escape($row["creditHours"]); ?></td>
                <td><a href="update-single.php?CRN=<?php echo escape($row["CRN"]); ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
