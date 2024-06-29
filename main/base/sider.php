<?php // Pastikan tidak ada spasi atau baris kosong sebelum tag PHP ini ?>
<aside class="hidden fixed lg:flex flex-col items-center w-24 h-screen py-8 overflow-y-auto bg-[#262430] border-r">
  <nav class="flex flex-col flex-1 space-y-6">
    <div class='flex flex-col items-center gap-2'>
      <a href="#">
        <img class="object-cover w-8 h-8 rounded-full" src="../assets/images/avatar.webp" alt="" />
      </a>
      <span class='block text-center text-sm text-white capitalize'><?=$_SESSION['username']?></span>
    </div>
    <div class='w-full h-[1px] bg-[#575376] mx-auto'></div>

    <ul class="mt-6 space-y-4">
      <?php
      foreach ($routes as $i => $v) { ?>
        <li>
          <a href="<?= $v['url'] ?>" class="p-1.5 font-medium focus:outline-none duration-200 hover:scale-90 transition-all flex flex-col items-center gap-1">
            <a href="<?= $v['url'] ?>" class="p-1.5 font-medium focus:outline-none duration-200 hover:scale-90 transition-all flex flex-col items-center gap-1">
              <?= $v['icon'] ?>
              <span class="block text-white text-xs text-center">
                <?= $v['label'] ?>
              </span>
            </a>
        </li>
      <?php } ?>
    </ul>
  </nav>

  <div class="flex flex-col space-y-6 mb-10 mt-4">
    <a href="?page=logout" class='hover:bg-[#302e3d] w-10 h-10 rounded-lg grid place-items-center' id="logout-button">
      <i class='bx bx-log-out text-2xl text-white'></i>
      <span class='block text-center text-xs  text-white capitalize'>logout</span>
    </a>
  </div>
</aside>
<?php // Pastikan tidak ada spasi atau baris kosong setelah tag PHP ini ?>
