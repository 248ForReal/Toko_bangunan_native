<main class="ml-[90px] p-8 bg-[#f2f2f2] min-h-screen">
  <!-- <h3 class="text-2xl font-semibold mb-10">
    
    <?= $head_title; ?>
  </h3> -->
  <?php
  if (array_key_exists($page, $pages)) {
    if (is_array($pages[$page]) && array_key_exists($action, $pages[$page])) {
      require_once $pages[$page][$action];
    } else {
      require_once $pages[$page];
    }
  } else {
    require_once './pages/dashboard/dashboard.php';
  }
  ?>
</main>