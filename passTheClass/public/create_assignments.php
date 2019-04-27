<?php
/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $assignment_name = $_POST['assignment_name'];
    $course_name = $_POST['course_name'];
    $percentage = $_POST['percentage'];
    $category_name = $_POST['category_name'];
    $due_date = $_POST['due_date'];
    $netId = $_POST['netId'];

    $grade = "
    SELECT demon.course_name AS course_name, (toast/satan)*100 AS grade
            FROM (	SELECT Assignment.course_name, SUM(percentage*0.01*calc) AS toast
                FROM ( SELECT creambang.course_name, creambang.category_name, weightage, weightage/COUNT(creambang.assignment_name) AS calc
                    FROM Category JOIN (SELECT * FROM Assignment WHERE netId = :netId) AS creambang ON Category.name = creambang.category_name
                      AND Category.course_name = creambang.course_name
                    GROUP BY creambang.category_name, creambang.course_name) AS table1,
                  Assignment
                WHERE Assignment.netId = :netId
                AND Assignment.category_name = table1.category_name AND Assignment.course_name = table1.course_name
                GROUP BY Assignment.course_name ) AS bread,
              (	SELECT dead.course_name, SUM(weightage) AS satan
                FROM (	SELECT grape.course_name, grape.category_name, weightage
                    FROM Category JOIN (SELECT * FROM Assignment WHERE netId = :netId) AS grape ON Category.name = grape.category_name
                        AND Category.course_name = grape.course_name
                    GROUP BY grape.category_name, grape.course_name ) AS dead
                GROUP BY dead.course_name) AS demon
            WHERE bread.course_name = demon.course_name
            GROUP BY demon.course_name;
    ";
    $statement = $connection->prepare($grade);
    $statement->bindValue(':netId', $netId);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $name) {
      for ($x = 0; $x < sizeof($name); $x++) {
        if ($name[$x] == $course_name) {
          $grade_single = $name[$x+1];
          break 2;
        }
      }


      //break; // break loop after first iteration
    }

    $sql = "
      INSERT INTO Assignment (assignment_name, percentage, due_date, category_name, course_name, netId)
      VALUES (:assignment_name, :percentage, :due_date, :category_name, :course_name, :netId);

      INSERT INTO Category_Assignment (assignment_name, category_name) VALUES (:assignment_name, :category_name);

      INSERT INTO Class_Grade_Log (netId, course_name, grade, time_stamp) VALUES (:netId, :course_name, :grade, :time_stamp);

      ";


    $statement = $connection->prepare($sql);
    $statement->bindValue(':assignment_name', $assignment_name);
    $statement->bindValue(':course_name', $course_name);
    $statement->bindValue(':percentage', $percentage);
    $statement->bindValue(':category_name', $category_name);
    $statement->bindValue(':due_date', $due_date);
    $statement->bindValue(':netId', $netId);
    $statement->bindValue(':time_stamp', date("Y-m-d"));
    $statement->bindValue(':grade', $grade_single);



    $statement->execute();


  } catch(PDOException $error) {
      echo $sql . "<br>" . $course_name . "<br>" . $assignment_name ."<br>" . $percentage ."<br>" . $category_name . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['assignment_name']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add an Assignment</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="assignment_name">Name</label>
    <input type="text" name="assignment_name" id="assignment_name">
    <label for="percentage">Percentage</label>
    <input type="number" name="percentage" min="0" value="0" step="0.05" id="percentage">
    <label for="Category">Category</label>
    <input type="text" name="category_name" id="category_name">
    <label for="Course">Course</label>
    <input type="text" name="course_name" id="course_name">
    <label for="netId">Net Id</label>
    <input type="text" name="netId" id="netId">
    <label for="DueDate">Due Date</label>
    <input type="date" name="due_date" id="due_date">
    <input type="submit" name="submit" value="Submit">
  </form>

  <button type="button" class="btn btn-primary" onclick="window.location.href = 'index.php';">Go Home</button>

<?php require "templates/footer.php"; ?>
