<?php
require "../config.php";
require "../common.php";
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM Category";

        $statement = $connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
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
                <td><a href="update-single_category.php?name=<?php echo escape($row["name"]); ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
