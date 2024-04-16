<nav class="main-header navbar navbar-expand">
  <ul class="navbar-nav">
    <li class="nav-item">
      <div class="custom-nav-link">
        <a data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </div>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto theme-switch-container">
    <li class="nav-item">
      <div class="theme-switch-wrapper nav-link">
        <label class="theme-switch" for="checkbox">
          <input type="checkbox" id="checkbox" />
          <span class="slider round"></span>
        </label>
      </div>
    </li>
  </ul>
<style>

</style>

</nav>
<script>
  var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
  var currentTheme = localStorage.getItem('theme');
  var mainHeader = document.querySelector('.main-header');

  if (currentTheme) {
    if (currentTheme === 'dark') {
      if (!document.body.classList.contains('dark-mode')) {
        document.body.classList.add("dark-mode");
      }
      if (mainHeader.classList.contains('navbar-light')) {
        mainHeader.classList.add('navbar-dark');
        mainHeader.classList.remove('navbar-light');
      }
      toggleSwitch.checked = true;
    }
  }

  function switchTheme(e) {
    if (e.target.checked) {
      if (!document.body.classList.contains('dark-mode')) {
        document.body.classList.add("dark-mode");
      }
      if (mainHeader.classList.contains('navbar-light')) {
        mainHeader.classList.add('navbar-dark');
        mainHeader.classList.remove('navbar-light');
      }
      localStorage.setItem('theme', 'dark');
    } else {
      if (document.body.classList.contains('dark-mode')) {
        document.body.classList.remove("dark-mode");
      }
      if (mainHeader.classList.contains('navbar-dark')) {
        mainHeader.classList.add('navbar-light');
        mainHeader.classList.remove('navbar-dark');
      }
      localStorage.setItem('theme', 'light');
    }
  }

  toggleSwitch.addEventListener('change', switchTheme, false);
</script>
