<?php 
$username = $token->FormName('user:'.round(microtime(true)) );
$password = $token->FormName('pass:'.round(microtime(true)) );
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Login</title>
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/css/default.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/css/accent.css">
    <script src="themes/<?= TEMPLATE; ?>/assets/js/jquery.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <style>
        element.style {
        }
        section.login-clean{
            max-width:300px;
            margin:0 auto ;
            padding: 80px 0;
            margin-top: 50px;
        }
        article, aside, figcaption, figure, footer, header, hgroup, main, nav, section {
          display: block;
        }
        body {
          margin: 0;
          font-family: Lato,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
          font-size: .7375rem;
          font-weight: 400;
          line-height: 1.5;
          color: #212529;
          text-align: left;
          background: #f1f7fc;          
        }

        html {

          font-family: sans-serif;
          line-height: 1.15;
          -webkit-text-size-adjust: 100%;
          -webkit-tap-highlight-color: transparent;
        }
        .logo{
            font-size: 30px;
            color: var(--blue);
            cursor: pointer;
            padding: 10px;
        }
        .iqr {
            --fa-primary-color: var(--red); 
            --fa-secondary-color: var(--blue);

        }

    </style>
</head>

<body>
    <section class="login-clean">
        <form method="post">
            <div class="container-fluid d-flex flex-column p-0">
                <span class="d-flex justify-content-center align-items-center m-0 logo" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fa-duotone fa-qrcode orange-accent-logo"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Mi1-Systems</span></div>
                </span>
            </div>
            </div>
            <div class="illustration"><i class="icon ion-ios-navigate" style="color: var(--cyan);"></i></div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" name="v<?= $username;?>" placeholder="username/email">
              <label for="floatingInput">Username/Email</label>
            </div>
            <div class="form-floating mb-3">
              <input type="password" class="form-control" id="floatingPassword"  name="v<?= $password;?>" placeholder="password">
              <label for="floatingPassword">Password</label>
            </div>

            <div class="form-group mb-3"><button class="btn btn-primary d-block btn-user w-100" type="submit">Log In</button></div>





            <center><a class="forgot" href="#">Forgot your username or password?</a></center>
        </form>
    </section>
    <script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/fontawesome.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/duotone.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/js/theme.js"></script>
</body>

</html>

