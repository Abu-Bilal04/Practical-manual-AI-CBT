<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
  
  <head>
    <title>Dashboard || Practical manual  system</title>
    
    <link rel="icon" href="../dist/assets/images/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="../dist/assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.css">

  </head>
  


  <body>
    
    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
      <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
        <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
      </div>
    </div>



    <nav class="pc-sidebar">
      <div class="navbar-wrapper">
        <div class="m-header flex items-center py-4 px-6 h-header-height">
          <a href="../dist/dashboard/index.php" class="b-brand flex items-center gap-3">
            <center>
              <img src="../dist/assets/images/logo/logo.jpeg" width="50%" alt="">
            </center>
          </a>
        </div>
        <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
          <ul class="pc-navbar">
            <li class="pc-item pc-caption">
            </li>
            <li class="pc-item">
            <li class="pc-item">
              <a href="index.php" class="pc-link">
                <span class="pc-micon">
                  <i data-feather="home"></i>
                </span>
                <span class="pc-mtext">Dashboard</span>
              </a>
            </li>

  
      </ul>
    </div>
  </div>
</nav>


<header class="pc-header">
  <div class="header-wrapper flex max-sm:px-[15px] px-[25px] grow">
<div class="me-auto pc-mob-drp">
  <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">

    <li class="pc-h-item pc-sidebar-collapse max-lg:hidden lg:inline-flex">
      <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="sidebar-hide">
        <i data-feather="menu"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup lg:hidden">
      <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="mobile-collapse">
        <i data-feather="menu"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item">
      <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <i data-feather="search"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-2 py-1">
          <input type="search" class="form-control !border-0 !shadow-none" placeholder="Search here. . ." />
        </form>
      </div>
    </li>
  </ul>
</div>

<div class="ms-auto">
  <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">

    
    <li class="dropdown pc-h-item header-user-profile">
      <a class="pc-head-link dropdown-toggle arrow-none me-0" data-pc-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" data-pc-auto-close="outside" aria-expanded="false">
        <i data-feather="user"></i>
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown p-2 overflow-hidden">
        <div class="dropdown-header flex items-center justify-between py-4 px-5 bg-primary-500">
          <div class="flex mb-1 items-center">
            <div class="shrink-0">
              <img src="../dist/assets/images/user/avatar-2.jpg" alt="user-image" class="w-10 rounded-full" />
            </div>
            <div class="grow ms-3">
              <h6 class="mb-1 text-white">Muhammad Ibrahim Musa</h6>
              <span class="text-white">Admin</span>
            </div>
          </div>
        </div>
        <div class="dropdown-body py-4 px-5">
          <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
            <a href="#" class="dropdown-item">
              <span>
                <input type="password" class="form-control">
              </span>
            </a>
           <center>
            <button class="btn btn-primary">Change Password</button>
           </center>
            <div class="grid my-3">
              <a href="../dist/pages/login.php" style="cursor: pointer;" class="btn btn-danger flex items-center justify-center">
                <svg class="pc-icon me-2 w-[22px] h-[22px]">
                  <use xlink:href="#custom-logout-1-outline"></use>
                </svg>
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div></div>
</header>



    <div class="pc-container">
      <div class="pc-content">
        <div class="page-header">
          <div class="page-block">
            <div class="page-header-title">
              <h5 class="mb-0 font-medium">Dashboard</h5>
            </div>
            <ul class="breadcrumb">
              <li><a href="index.php">Home</a></li>
              <i class="bi bi-arrow-right-circle"></i>
              <li><a href="index.php">Dashboard</a></li>
            </ul>
          </div>
        </div>

        <div class="grid grid-cols-12 gap-x-6">
          <div class="col-span-12 xl:col-span-3 md:col-span-6">
                <div class="card">
                    <div class="card-header !pb-0 !border-b-0">
                    <h5>CSC 201</h5> <!-- Course Code -->
                    </div>
                    <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-medium">Introduction to Programming</h6> <!-- Course Title -->
                    </div>
                    
                    <div class="mb-3 flex items-center gap-2">
                        <i class="bi bi-clock text-primary"></i>
                        <span id="countdown-1">00:30:00</span> <!-- Countdown -->
                    </div>
                    
                    <div class="text-center">
                        <button class="btn btn-primary w-full">Take Test</button> <!-- Button -->
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-3 md:col-span-6">
                <div class="card">
                    <div class="card-header !pb-0 !border-b-0">
                    <h5>CSC 201</h5> <!-- Course Code -->
                    </div>
                    <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-medium">Introduction to Programming</h6> <!-- Course Title -->
                    </div>
                    
                    <div class="mb-3 flex items-center gap-2">
                        <i class="bi bi-clock text-primary"></i>
                        <span id="countdown-1">00:30:00</span> <!-- Countdown -->
                    </div>
                    
                    <div class="text-center">
                        <button class="btn btn-primary w-full">Take Test</button> <!-- Button -->
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-3 md:col-span-6">
                <div class="card">
                    <div class="card-header !pb-0 !border-b-0">
                    <h5>CSC 201</h5> <!-- Course Code -->
                    </div>
                    <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-medium">Introduction to Programming</h6> <!-- Course Title -->
                    </div>
                    
                    <div class="mb-3 flex items-center gap-2">
                        <i class="bi bi-clock text-primary"></i>
                        <span id="countdown-1">00:30:00</span> <!-- Countdown -->
                    </div>
                    
                    <div class="text-center">
                        <button class="btn btn-primary w-full">Take Test</button> <!-- Button -->
                    </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
    <script>
    function startCountdown(elementId, durationInSeconds) {
    let timer = durationInSeconds;
    const countdownElement = document.getElementById(elementId);

    const interval = setInterval(() => {
        let hours = Math.floor(timer / 3600);
        let minutes = Math.floor((timer % 3600) / 60);
        let seconds = timer % 60;

        countdownElement.textContent = 
        `${hours.toString().padStart(2, '0')}:` +
        `${minutes.toString().padStart(2, '0')}:` +
        `${seconds.toString().padStart(2, '0')}`;

        if (--timer < 0) {
        clearInterval(interval);
        countdownElement.textContent = "Time's up!";
        }
    }, 1000);
    }

    // Example usage:
    startCountdown("countdown-1", 1800); // 30 minutes
    // startCountdown("countdown-2", 3600); // 1 hour
    </script>

    <script src="../dist/assets/js/plugins/simplebar.min.js"></script>
    <script src="../dist/assets/js/plugins/popper.min.js"></script>
    <script src="../dist/assets/js/icon/custom-icon.js"></script>
    <script src="../dist/assets/js/plugins/feather.min.js"></script>
    <script src="../dist/assets/js/component.js"></script>
    <script src="../dist/assets/js/theme.js"></script>
    <script src="../dist/assets/js/script.js"></script>

    <div class="floting-button fixed bottom-[50px] right-[30px] z-[1030]">
    </div>

    
    <script>
      layout_change('false');
    </script>
     
    
    <script>
      layout_theme_sidebar_change('dark');
    </script>
    
     
    <script>
      change_box_container('false');
    </script>
     
    <script>
      layout_caption_change('true');
    </script>
     
    <script>
      layout_rtl_change('false');
    </script>
     
    <script>
      preset_change('preset-1');
    </script>
     
    <script>
      main_layout_change('vertical');
    </script>
    

  </body>
</html>
