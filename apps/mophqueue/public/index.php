<?php include 'access.php'; ?>
<?php 
global $conf;
function get_absolute_path($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }


 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MOPH - PhilHealth Verification Queue</title>
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/DataTables/datatables.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/css/default.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/css/accent.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/jqui/jquery-ui.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/fontawesome/css/duotone.min.css">
    <script src="themes/<?= TEMPLATE; ?>/assets/js/jquery.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/jqui/jquery-ui.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/DataTables/datatables.min.js"></script>
    <script src="vendors/chart.js/chart.min.js"></script>
    <script src="vendors/chart.js/chartjs-plugin-datalabels.min.js"></script>
    <style>
        .attachment-content {
            height: 400px;
            width: cover;
        }
        .item-placeholder {
            width: 100%;
            border: 1px dotted black;
            margin: 0 1em 1em 0;
            height: 50px;
        }   
        .text-divider{margin: 2em 0; line-height: 0; text-align: center;}
        .text-divider span{background-color: #ffffff; padding: 1em;}
        .text-divider:before{ content: " "; display: block; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #f7f7f7;}

    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-light align-items-start sidebar sidebar-light accordion bg-gradient-primary p-0 " style="background: linear-gradient(#f5f5f5 0%, #c6c6c6), var(--bs-light);">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fa-duotone fa-qrcode orange-accent-logo"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Mi1-Systems</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <?php include "sidebar/left.php"; ?>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fad fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">
                                                      <?php
                                        /**
                                         * PROFILE NICK NAME
                                         * ADDED ON: December 17, 2021
                                         */
                                        if (isset($_COOKIE['_uid'])) {
                                            echo "Hi! ".GetEntityProfile($_COOKIE['_uid'])["firstname"];
                                        }
                                  ?>

                                </span><img class="border rounded-circle img-profile" src="themes/<?= TEMPLATE; ?>/assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="?route=admin&page=account&fn=manage.profile"><i class="fad fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fad fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fad fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="fad fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">


                  <?php 
                        if (file_exists( get_absolute_path(__DIR__."\\".$access) )) {
                            if (file_exists( get_absolute_path(__DIR__."\\".$modmenu) )) {
                                include $modmenu; 
                            }
                            include $access; 
                        }else{
                            echo "ERROR: 404; PAGE NOT FOUND";
                        }
                    ?>




                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Mi1-Systems <?=$conf["dateseries"];?></span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fa-duotone fa-angle-up"></i></a>
    </div>
    <script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/fontawesome.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/duotone.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/js/chart.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/js/bs-init.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/js/jquery.easing.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/js/theme.js"></script>
</body>

</html>