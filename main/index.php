<?php require "../db/config.php" ?>
<?php require "./base/routes.php" ?>
<?php require "../utilities/query-func.php" ?>
<?php require "../utilities/to-percent.php" ?>
<?php require "../utilities/auth-func.php" ?>

<?php 
if (!isset($_SESSION['username'])) {
    header("Location: ../");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main | Sumber Rezeki</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>
  <?php include "./base/sider.php" ?>
  <?php include "./main.php" ?>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script>
  new DataTable('#datatable-style');
</script>

</html>