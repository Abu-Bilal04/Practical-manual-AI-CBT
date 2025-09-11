<?php include "../include/server.php"; ?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
  <!-- [Head] start -->

  <head>
    <title>Login || Practical manual verification system</title>
    <link rel="icon" href="../dist/assets/images/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="../dist/assets/css/style.css" id="main-style-link" />

  <!-- iziToast -->
  <link href="iziToast/css/iziToast.min.css" rel="stylesheet" />
  <script src="iziToast/js/iziToast.min.js" type="text/javascript"></script>

  </head>

  <body>
    
  <?php if (isset($_GET['msg']) && $_GET['msg'] == "error") { ?>
  <script>
    iziToast.error({
      title: '',
      message: 'Error, try again',
      position: 'topCenter',
      animateInside: true
    });
  </script>
  <?php } ?>

    <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
      <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
        <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 animate-[hitZak_0.6s_ease-in-out_infinite_alternate]"></div>
      </div>
    </div>

    <div class="auth-main relative">
      <div class="auth-wrapper v1 flex items-center w-full h-full min-h-screen">
        <div class="auth-form flex items-center justify-center grow flex-col min-h-screen relative p-6 ">
          <div class="w-full max-w-[350px] relative">
            <div class="auth-bg ">
              <span class="absolute top-[-100px] right-[-100px] w-[300px] h-[300px] block rounded-full bg-theme-bg-1 animate-[floating_7s_infinite]"></span>
              <span class="absolute top-[150px] right-[-150px] w-5 h-5 block rounded-full bg-primary-500 animate-[floating_9s_infinite]"></span>
              <span class="absolute left-[-150px] bottom-[150px] w-5 h-5 block rounded-full bg-theme-bg-1 animate-[floating_7s_infinite]"></span>
              <span class="absolute left-[-100px] bottom-[-100px] w-[300px] h-[300px] block rounded-full bg-theme-bg-2 animate-[floating_9s_infinite]"></span>
            </div>
            <form method="post">
              <div class="card sm:my-12  w-full shadow-none">
              <div class="card-body !p-10">
                <div class="text-center mb-8">
                  <!-- <a href="#"><img src="" alt="img" class="mx-auto auth-logo"/></a> -->
                </div>
                <h4 class="text-center font-medium mb-4">Admin Login</h4>
                <div class="mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Enter username" name="username"/>
                </div>
                <div class="mb-4">
                  <input type="password" class="form-control" id="floatingInput1" placeholder="Enter password" name="password"/>
                </div>
                <div class="flex mt-1 justify-between items-center flex-wrap">
                </div>
                <div class="mt-4 text-center">
                  <button type="submit" class="btn btn-primary mx-auto shadow-2xl" name="login">Login</button>
                </div>
                <div class="flex justify-between items-end flex-wrap mt-4">
                </div>
              </div>
            </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>
    <!-- Required Js -->
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
  <!-- [Body] end -->
</html>
