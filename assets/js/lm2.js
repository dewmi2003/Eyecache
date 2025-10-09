    const toggleBtn = document.getElementById('theme-toggle');
    const icon = document.getElementById('theme-icon');
    const text = document.getElementById('theme-text');

    function setLightMode() {
      document.documentElement.classList.remove('dark');
      localStorage.theme = 'light';
      icon.textContent = '🌙';
      text.textContent = 'Dark Mode';
    }

    function setDarkMode() {
      document.documentElement.classList.add('dark');
      localStorage.theme = 'dark';
      icon.textContent = '🌞';
      text.textContent = 'Light Mode';
    }

    toggleBtn.addEventListener('click', () => {
      if (document.documentElement.classList.contains('dark')) {
        setLightMode();
      } else {
        setDarkMode();
      }
    });

    // Set correct initial icon and text
    if (document.documentElement.classList.contains('dark')) {
      icon.textContent = '🌞';
      text.textContent = 'Light Mode';
    } else {
      icon.textContent = '🌙';
      text.textContent = 'Dark Mode';
    }