<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Pass The Class</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>
    <h1>Pass the Class</h1>

    <?php include "templates/header.php"; ?>

    <ul>
      <li>
        <a href="create.php"><strong>Create</strong></a> - add a Class
      </li>
      <li>
        <a href="read.php"><strong>Read</strong></a> - find a Class
      </li>
      <li>
        <a href="update.php"><strong>Update</strong></a> - edit a Class
      </li>
      <li>
        <a href="delete.php"><strong>Delete</strong></a> - delete a Class
      </li>
    </ul>

    <?php include "templates/footer.php"; ?>

  </body>
</html>
