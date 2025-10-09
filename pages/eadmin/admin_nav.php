<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<aside class="w-64 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 flex flex-col shadow-lg transition-colors duration-300">
  <div class="px-6 py-4 flex items-center gap-3 border-b dark:border-gray-700">
    <div class="p-2 bg-[var(--primary-color)] rounded-full text-white">
      <span class="material-symbols-outlined">store</span>
    </div>
    <h1 class="text-xl font-bold">Admin Panel</h1>
  </div>

  <div class="flex-1 flex flex-col justify-between">
    <nav class="px-4 py-4 space-y-2">
      <a class="flex items-center gap-3 px-4 py-2 rounded-md <?= $currentPage=='home.php' ? 'bg-[var(--primary-color)] text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' ?> font-medium"
         href="home.php">
        <span class="material-symbols-outlined">home</span><span>Home</span>
      </a>

      <a class="flex items-center gap-3 px-4 py-2 rounded-md <?= $currentPage=='products.php' ? 'bg-[var(--primary-color)] text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' ?> font-medium"
         href="products.php">
        <span class="material-symbols-outlined">inventory_2</span><span>Products</span>
      </a>

      <a class="flex items-center gap-3 px-4 py-2 rounded-md <?= $currentPage=='users.php' ? 'bg-[var(--primary-color)] text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' ?> font-medium"
         href="users.php">
        <span class="material-symbols-outlined">group</span><span>Users</span>
      </a>

      <a class="flex items-center gap-3 px-4 py-2 rounded-md <?= $currentPage=='customers.php' ? 'bg-[var(--primary-color)] text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' ?> font-medium"
         href="customers.php">
        <span class="material-symbols-outlined">people</span><span>Customers</span>
      </a>

      <!-- 🌗 Dark/Light Mode Toggle -->
      <button id="theme-toggle"
              class="flex items-center gap-2 px-4 py-2 mt-4 rounded-lg border border-gray-400 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all w-full">
        <span id="theme-icon">🌞</span>
        <span id="theme-text">Light Mode</span>
      </button>
    </nav>

    <div class="px-4 py-4 border-t dark:border-gray-700">
      <div class="flex items-center gap-3 mb-4">
        <img alt="User Avatar" class="w-10 h-10 rounded-full"
             src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['full_name']) ?>&background=random" />
        <div>
          <p class="font-semibold"><?= $_SESSION['full_name'] ?></p>
          <p class="text-sm text-gray-500 dark:text-gray-400"><?= $_SESSION['role'] ?></p>
        </div>
      </div>
      <a class="flex items-center gap-3 px-4 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors mt-2" href="logout.php">
        <span class="material-symbols-outlined">logout</span><span>Logout</span>
      </a>
    </div>
  </div>
</aside>

<script>
// Dark/Light Mode Toggle
document.addEventListener('DOMContentLoaded', () => {
  const html = document.documentElement;
  const btn = document.getElementById('theme-toggle');
  const icon = document.getElementById('theme-icon');
  const text = document.getElementById('theme-text');

  // Initial state
  const stored = localStorage.getItem('theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  let isDark = stored === 'dark' || (!stored && prefersDark);
  html.classList.toggle('dark', isDark);
  updateUI(isDark);

  // Toggle on click
  btn.addEventListener('click', () => {
    isDark = html.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    updateUI(isDark);
  });

  function updateUI(dark) {
    icon.textContent = dark ? '🌙' : '🌞';
    text.textContent = dark ? 'Dark Mode' : 'Light Mode';
  }
});
</script>
