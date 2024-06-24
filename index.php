<?php 
require "./db/config.php";
require "./utilities/auth-func.php";

if (isset($_SESSION['username'])) {
    header("Location: main/");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    login($_POST['username'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Sumber Rezeki</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./assets/css/index.css">
</head>
<body>
  <div class="grid place-items-center min-h-screen bg-[#d7d6e1]">
    <div class="flex flex-col gap-5 p-4">
      <div class="bg-white flex flex-col max-w-sm p-6 rounded-lg sm:p-10 border border-gray-300">
        <div class="mb-8 text-center">
          <img src="./assets/images/logo.png" alt="" class="w-fit h-fit scale-50 mx-auto object-cover" />
          <h1 class="mb-3 -mt-10 text-2xl md:text-4xl lg:text-4xl font-bold">Masuk</h1>
          <p class="text-xs md:text-sm lg:text-sm">Sistem POS Toko Bangunan Sumber Rezeki Rokan Hulu</p>
          <p class="text-xs md:text-sm lg:text-sm text-gray-500">(Offline)</p>
        </div>
        <form method="post" action="" class="space-y-12">
          <div class="space-y-4">
            <div>
              <label for="username" class="block mb-2 text-xs md::text-sm lg:text-sm">Nama Pengguna</label>
              <input type="text" name="username" id="username" placeholder="Nama Pengguna" class="text-sm w-full px-3 py-2 border rounded-md" />
            </div>
            <div>
              <label for="password" class="text-xs md::text-sm lg:text-sm">Kata Sandi</label>
              <input type="password" name="password" id="password" placeholder="*****" class="text-sm w-full px-3 py-2 border rounded-md" />
            </div>
          </div>
          <div class="space-y-2">
            <div>
              <button type="submit" class="bg-[#3e3b51] hover:bg-[#5b5578] transition-all duration-300 text-white w-full px-8 py-2 md:py-2.5 lg:py-3 text-sm font-semibold rounded-md">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
</body>
</html>
