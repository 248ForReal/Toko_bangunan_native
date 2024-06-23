<aside class="hidden fixed lg:flex flex-col items-center w-24 h-screen py-8 overflow-y-auto bg-[#262430] border-r">
  <nav class="flex flex-col flex-1 space-y-6">
    <div class='flex flex-col items-center gap-2'>
      <a href="#">
        <img class="object-cover w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=4&w=880&h=880&q=100" alt="" />
      </a>
      <span class='block text-center text-sm text-white capitalize'>admin</span>
    </div>
    <div class='w-full h-[1px] bg-[#575376] mx-auto'></div>

    <ul class="mt-6 space-y-4">
      <?php
      foreach ($routes as $i => $v) { ?>
        <li>
          <a href="<?= $v['url'] ?>" class="p-1.5 font-medium focus:outline-none duration-200 hover:scale-90 transition-all flex flex-col items-center gap-1">
            <?= $v['icon'] ?>
            <span class="block text-white text-xs text-center">
              <?= $v['label'] ?>
            </span>
          </a>
        </li>        
      <?php } ?>
      <li><a href="./pages/logout.php">
          Logout
        </a></li>
    </ul>
  </nav>

  <div class="flex flex-col space-y-6">
    <button type="button" class='hover:bg-[#302e3d] w-10 h-10 rounded-lg grid place-items-center' id="logout-button">
      Logout
    </button>
  </div>
</aside>


