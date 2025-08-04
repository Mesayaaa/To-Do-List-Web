<?php
session_start();

$koneksi = mysqli_connect("localhost", "root", "", "todo");

if (mysqli_connect_errno()) {
  die("Koneksi database gagal: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

function sanitize_input($input)
{
  global $koneksi;
  return mysqli_real_escape_string($koneksi, $input);
}

function hash_password($password)
{
  return password_hash($password, PASSWORD_DEFAULT);
}

function is_logged_in()
{
  return isset($_SESSION['user_id']);
}

function redirect_if_not_logged_in()
{
  if (!is_logged_in()) {
    header("Location: login.php");
    exit();
  }
}

redirect_if_not_logged_in();

// Handle checkbox for marking task as done
if (isset($_POST['updateStatus']) && isset($_POST['id'])) {
  $taskId = (int) $_POST['id'];
  $isChecked = isset($_POST['check']);

  if ($isChecked) {
    $sql = "UPDATE tbl_tugas SET status='Done' WHERE id = $taskId";
  } else {
    $sql = "UPDATE tbl_tugas SET status='No Status' WHERE id = $taskId";
  }
  mysqli_query($koneksi, $sql);
}

if (isset($_POST['submit'])) {
  $tugas = sanitize_input($_POST['listBaru']);
  $priority = sanitize_input($_POST['priority']);

  $tugas = mysqli_escape_string($koneksi, $tugas);
  $priority = mysqli_escape_string($koneksi, $priority);

  $sql = "INSERT INTO tbl_tugas (priority, tugas, status)
            VALUES ('{$priority}', '{$tugas}', 'No Status')";
  mysqli_query($koneksi, $sql);
}

if (isset($_GET['status']) && isset($_GET['id'])) {
  $id = (int) $_GET['id']; // Cast to integer to ensure it is a valid ID.
  if ($_GET['status'] == 1) {
    $sql = "UPDATE tbl_tugas SET status='On Progress' WHERE id = $id";
  } else if ($_GET['status'] == 2) {
    $sql = "UPDATE tbl_tugas SET status='Cancelled' WHERE id = $id";
  } else if ($_GET['status'] == 3) {
    $sql = "UPDATE tbl_tugas SET status='Done' WHERE id = $id";
  } else if ($_GET['status'] == 4) {
    $sql = "DELETE FROM tbl_tugas WHERE id = $id";
  }
  mysqli_query($koneksi, $sql);
}

$sql = "SELECT * FROM tbl_tugas ORDER BY priority DESC, status ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-Do List</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container-fluid">
    <div class='d-flex justify-content-center align-items-center w-100 h-100 flex-column'>
      <h1 class="mb-3">To-do list</h1>
      <form action="todo.php" method='POST' class="mb-3">
        <label>New To Do</label>
        <input type="text" name="listBaru" id="listBaru" required>
        <select name="priority" id="option">
          <option value="High">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
        </select>
        <input type="submit" value="Add" class="Add rounded-3" name="submit">
      </form>

      <table class="table table-sm">
        <thead class="table-primary">
          <tr>
            <th scope="col">Priority</th>
            <th scope="col">Task</th>
            <th scope="col">Progress</th>
            <th scope="col">Update</th>
            <th scope="col">Done</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($baris = mysqli_fetch_assoc($hasil)) {
            echo "<tr>";
            echo "<td scope='row'>";
            echo $baris['priority'];
            echo "</td>";

            echo "<td scope='row'>";
            echo $baris['tugas'];
            echo "</td>";

            echo "<td scope='row'>";
            echo $baris['status'];
            echo "</td>";

            echo "<td>";
            echo "<a href='start.php?id=" . $baris['id'] . "'>Start</a> |";
            echo "<a href='cancel.php?id=" . $baris['id'] . "'>Cancel</a> |";
            echo "<a href='delete.php?id=" . $baris['id'] . "'>Delete</a> |";
            echo "</td>";

            echo "<td>";
            echo "<form action='todo.php' method='POST' style='display:inline;'>";
            echo "<input type='checkbox' name='check' onchange='this.form.submit()' " . ($baris['status'] == 'Done' ? 'checked' : '') . ">";
            echo "<input type='hidden' name='id' value='" . $baris['id'] . "'>";
            echo "<input type='hidden' name='updateStatus' value='1'>";
            echo "</form>";
            echo "</td>";

            echo "</tr>";
          }

          mysqli_free_result($hasil);
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>

<?php
mysqli_close($koneksi);
?>