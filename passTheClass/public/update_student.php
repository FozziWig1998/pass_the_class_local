<?php
require "../config.php";
require "../common.php";
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "SELECT * FROM Student";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
?>

<?php require "templates/header.php" ?>

<h2>Update Student</h2>

<table>
    <thead>
        <tr>
            <th>netId</th>
            <th>year</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["netId"]); ?></td>
                <td><?php echo escape($row["year"]); ?></td>
                <td><a href="update-single_category.php?name=<?php echo escape($row["netId"]); ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
