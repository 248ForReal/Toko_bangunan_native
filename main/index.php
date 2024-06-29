  <?php require "../db/config.php" ?>
  <?php require "./base/routes.php" ?>
  <?php require "../utilities/query-func.php" ?>
  <?php require "../utilities/to-percent.php" ?>
  <?php require "../utilities/auth-func.php" ?>
  <?php require "../utilities/sync-func.php" ?>
  <?php require "../vendor/autoload.php"?>

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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../assets/css/index.css">
  <link rel="stylesheet" href="../assets/css/tailwindbuild.css">
  <link rel="stylesheet" href="../node_modules/datatables.net-dt/css/dataTables.dataTables.css">
</head>

  <body>
    <?php include "./base/sider.php" ?>
    <?php include "./main.php" ?>

</body>
<script type="text/javascript" src="../node_modules/jquery/dist/jquery.js" ></script>
<script type="text/javascript" src="../node_modules/datatables.net/js/dataTables.js" ></script>
<script>
  new DataTable('#datatable-style');
</script>

  </html>