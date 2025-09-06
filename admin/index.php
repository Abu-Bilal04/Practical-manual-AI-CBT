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
              <a href="../dist/dashboard/index.php" class="pc-link">
                <span class="pc-micon">
                  <i data-feather="home"></i>
                </span>
                <span class="pc-mtext">Dashboard</span>
              </a>
            </li>
            <li class="pc-item pc-caption">
              <label>Navigations</label>
              <i data-feather="feather"></i>
            </li>
            <li class="pc-item pc-hasmenu">
              <a href="manage_session.php" class="pc-link">
                <span class="pc-micon"> <i class="bi bi-calendar-check"></i></span>
                <span class="pc-mtext">Manage sessions</span>
              </a>
            </li>

            <li class="pc-item pc-hasmenu">
              <a href="manage_level.php" class="pc-link">
                <span class="pc-micon"> <i class="bi bi-layers"></i></span>
                <span class="pc-mtext">Manage levels</span>
              </a>
            </li>

            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">
                <span class="pc-micon"> <i class="bi bi-people"></i></span>
                <span class="pc-mtext">Students</span>
                <span class="pc-arrow"><i class="bi bi-caret-right"></i></span>
              </a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="register_student.php"><i class="bi bi-person-plus"></i> Register</a></li>
                <li class="pc-item"><a class="pc-link" href="view_student.php"><i class="bi bi-person-lines-fill"></i> View</a></li>
              </ul>
            </li>

            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">
                <span class="pc-micon"> <i class="bi bi-journal-text"></i></span>
                <span class="pc-mtext">Manuals</span>
                <span class="pc-arrow"><i class="bi bi-caret-right"></i></span>
              </a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="set_question.php"><i class="bi bi-pencil-square"></i> Set question</a></li>
                <li class="pc-item"><a class="pc-link" href="questions.php"><i class="bi bi-book"></i> View manuals</a></li>
              </ul>
            </li>

            <li class="pc-item pc-hasmenu">
              <a href="results.php" class="pc-link">
                <span class="pc-micon"> <i class="bi bi-clipboard-data"></i></span>
                <span class="pc-mtext">Results</span>
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
                <h5>Total Manuals</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <i class="feather icon-arrow-up text-success-500 text-[30px] mr-1.5"></i>
                    43
                  </h3>
                </div>
                
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-3 md:col-span-6">
            <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Total Students</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <i class="feather icon-arrow-down text-danger-500 text-[30px] mr-1.5"></i>
                    676
                  </h3>
                  
                </div>
                
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-3 md:col-span-6">
            <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Total Departments</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <i class="feather icon-arrow-down text-danger-500 text-[30px] mr-1.5"></i>
                    676
                  </h3>
                  
                </div>
                
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-3 md:col-span-6">
            <div class="card">
              <div class="card-header !pb-0 !border-b-0">
                <h5>Total Level</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                  <h3 class="font-light flex items-center mb-0">
                    <i class="feather icon-arrow-down text-danger-500 text-[30px] mr-1.5"></i>
                    676
                  </h3>
                  
                </div>
                
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-8 md:col-span-6">
            <div class="card table-card">
              <div class="card-header">
                <h5>Pending Submissions</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tbody>
                      <tr class="unread">
                        <td>
                          <img class="rounded-full max-w-10" style="width: 40px" src="../dist/assets/images/user/avatar-1.jpg" alt="activity-user" />
                        </td>
                        <td>
                          <h6 class="mb-1">Isabella Christensen</h6>
                          <p>Science Lab. Tech.</p>
                          
                        </td>
                        <td>
                          <h6 class="text-muted">
                            <i class="fas fa-circle text-success text-[10px] ltr:mr-4 rtl:ml-4"></i>
                            11 MAY 12:56
                          </h6>
                        </td>
                        <td>
                          <a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">View</a>
                          <!-- <a href="#!" class="badge text-white text-[12px] mx-2" style="background-color: red;">Reject</a>
                          <a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Approve</a> -->
                        </td>
                      </tr>
                      <tr class="unread">
                        <td>
                          <img class="rounded-full max-w-10" style="width: 40px" src="../dist/assets/images/user/avatar-2.jpg" alt="activity-user" />
                        </td>
                        <td>
                          <h6 class="mb-1">Mathilde Andersen</h6>
                          <p>Computer Science</p>
                        </td>
                        <td>
                          <h6 class="text-muted">
                            <i class="fas fa-circle text-danger text-[10px] ltr:mr-4 rtl:ml-4"></i>
                            11 MAY 10:35
                          </h6>
                        </td>
                        <td>
                          <a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">View</a>
                          <!-- <a href="#!" class="badge text-white text-[12px] mx-2" style="background-color: red;">Reject</a>
                          <a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Approve</a> -->
                        </td>
                      </tr>
                      <tr class="unread">
                        <td>
                          <img class="rounded-full max-w-10" style="width: 40px" src="../dist/assets/images/user/avatar-3.jpg" alt="activity-user" />
                        </td>
                        <td>
                          <h6 class="mb-1">Karla Sorensen</h6>
                          <p>Computer Science</p>                          
                        </td>
                        <td>
                          <h6 class="text-muted">
                            <i class="fas fa-circle text-success text-[10px] ltr:mr-4 rtl:ml-4"></i>
                            9 MAY 17:38
                          </h6>
                        </td>
                        <td>
                          <a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">View</a>
                          <!-- <a href="#!" class="badge text-white text-[12px] mx-2" style="background-color: red;">Reject</a>
                          <a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Approve</a> -->
                        </td>
                      </tr>
                      <tr class="unread">
                        <td>
                          <img class="rounded-full max-w-10" style="width: 40px" src="../dist/assets/images/user/avatar-1.jpg" alt="activity-user" />
                        </td>
                        <td>
                          <h6 class="mb-1">Ida Jorgensen</h6>
                          <p>Polymer And Textile</p>

                        </td>
                        <td>
                          <h6 class="text-muted f-w-300">
                            <i class="fas fa-circle text-danger text-[10px] ltr:mr-4 rtl:ml-4"></i>
                            19 MAY 12:56
                          </h6>
                        </td>
                        <td>
                          <a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">View</a>
                          <!-- <a href="#!" class="badge text-white text-[12px] mx-2" style="background-color: red;">Reject</a>
                          <a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Approve</a> -->
                        </td>
                      </tr>
                      <tr class="unread">
                        <td>
                          <img class="rounded-full max-w-10" style="width: 40px" src="../dist/assets/images/user/avatar-2.jpg" alt="activity-user" />
                        </td>
                        <td>
                          <h6 class="mb-1">Albert Andersen</h6>
                          <p>Leather Prod.</p>
                        </td>
                        <td>
                          <h6 class="text-muted">
                            <i class="fas fa-circle text-success text-[10px] ltr:mr-4 rtl:ml-4"></i>
                            21 July 12:56
                          </h6>
                        </td>
                        <td>
                          <a href="#!" class="badge bg-theme-bg-2 text-white text-[12px] mx-2">View</a>
                          <!-- <a href="#!" class="badge text-white text-[12px] mx-2" style="background-color: red;">Reject</a>
                          <a href="#!" class="badge bg-theme-bg-1 text-white text-[12px]">Approve</a> -->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-4 md:col-span-6">
            <div class="card user-list">
              <div class="card-header">
                <h5><i class="bi bi-"></i>Submission Percentage (%)</h5>
              </div>
              <div class="card-body">
                <div class="flex items-center justify-between gap-1 mb-5">
                  <h4 class="font-light flex items-center m-0">
                    Departments
                    <i class="fas fa-star text-[10px] ml-2.5 text-warning-500"></i>
                  </h4>
                  <h6 class="flex items-center m-0">
                    <b>34%</b>
                    <i class="fas fa-caret-up text-success text-[22px] ml-2.5"></i>
                  </h6>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    Computer Science
                  </h6>
                  <h6>74%</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 70%"
                  ></div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    Leather Prod.
                  </h6>
                  <h6>38%</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 35%"
                  ></div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    Polymer And Textile
                  </h6>
                  <h6>24%</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 25%"
                  ></div>
                </div>

                <div class="flex items-center justify-between gap-2 mb-2">
                  <h6 class="flex items-center gap-1">
                    <i class="fas fa-star text-[10px] mr-2.5 text-warning-500"></i>
                    Science Lab. Tech.
                  </h6>
                  <h6>8%</h6>
                </div>
                <div class="w-full bg-theme-bodybg rounded-lg h-1.5 mb-6 mt-3 dark:bg-themedark-bodybg">
                  <div
                    class="bg-theme-bg-1 h-full rounded-lg shadow-[0_10px_20px_0_rgba(0,0,0,0.3)]"
                    role="progressbar"
                    style="width: 10%"
                  ></div>
                </div>

              </div>
            </div>
          </div>
        </div>
        


      </div>
    </div>
    
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
