<?php include 'access.php'; ?>
<?php 
global $conf;
$token = new NameTokenizer();
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
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/flip/flip.min.css">
    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/fontawesome/css/duotone.min.css">
    <script src="themes/<?= TEMPLATE; ?>/assets/js/jquery-3.6.0.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="themes/<?= TEMPLATE; ?>/assets/DataTables/datatables.min.js"></script>
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

        .height{

            height: 30vh;
        }

        .form{

            position: relative;
        }

        .form .fa-search{

            position: absolute;
            top:20px;
            left: 20px;
            color: #9ca3af;
        }

        .form span{

            position: absolute;
            right: 17px;
            top: 13px;
            padding: 2px;
            border-left: 1px solid #d1d5db;
        }

        .left-pan{
            padding-left: 7px;
        }

        .left-pan i{
           padding-left: 10px;
        }

        .form-input{
            height: 55px;
            text-indent: 33px;
            border-radius: 10px;
        }

        .form-input:focus{

            box-shadow: none;
            border:none;
        }
        .tick-wrapper {
            margin: 0 auto !important;
        }
        .tick {
            font-size: 40pt;
        }
        .wrapper {
            display: block;
            /*font-size: 200px;*/
            margin: 0 auto;
            text-align: left;
        }


    </style>
</head>
<body>
  <?php 
    if (isset($_COOKIE['_uid'])) {
        $id = $_COOKIE['_uid'];
        $object =  GetEntityProfile($id)["objid"];
        $profile =  GetEntityProfile($id);
        $role = json_decode($token->FormName(GetAccountSystemsProfile($object)['role'],"decrypt"));
    }
 ?>
<div class="container">
    <div class="row height d-flex justify-content-center align-items-center">
      <div class="col-md-6">
        <div class="form">
            <center><h1>Patient Information Search</h1></center>
            <div class="form-control form-group">          
                <input type="search" class="form-control form-input" id="search" placeholder="Search any name...">
                <center>
                <div class="form-group">
                    <label>Search Sensitivity: </label>
                    <label class="col-md-3">
                        <input class="input-switch" type="radio" name="sensitivity" value="45" > Alternative
                    </label>
                    <label class="col-md-3">
                        <input class="input-switch" type="radio" name="sensitivity" value="65" checked=""> Familiar
                    </label>
                    <label class="col-md-3">
                        <input class="input-switch" type="radio" name="sensitivity" value="90"> Precise
                    </label>
                </div>
            </div>
            <center>
            <center>
            <button id="searchBtn" style="margin-top:10px;" class="btn btn-warning">Search Name</button>
            <!-- <button id="raffleBtn" style="margin-top:10px;" class="btn btn-warning">Button</button> -->
            </center>
        </div>
      </div>
    </div>
</div>
<!-- Module Menu End -->
 <div class="modal fade"  data-backdrop="static" role="dialog" tabindex="-1" id="toolModal" style="display: auto;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button class="btn btn-primary" id="btn-print" type="button">Print Request</button> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="toolbox">

                </div>
                <div id="elementH"></div>
            </div>
            <div class="modal-footer">
                <!-- <button class="btn btn-light" type="button" data-bs-dismiss="modal" aria-label="Close">Close</button> -->
                <!-- <button class="btn btn-primary" id="btn-save" type="button">Save</button> -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("input#search").focus();
    });
    function search() {
       /* Act on the event */
        var name = $("input#search").val();
        var sensitivity = $("input[name=sensitivity]:checked").val();
        var data = {
            method:"search",
            search: name,
            sensitivity: sensitivity,
        };
        if (name != "") {        
           $("#toolbox").load( "?form=form.search.entity",data, function() {
                $('.modal').modal('show');
           });
        }else{
           // $("#search"). 
        }
    }

    $("input#search").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            search();
        }
    });
    $("#searchBtn").click(function(event) {
         search();
    });

</script>
<script src="themes/<?= TEMPLATE; ?>/assets/flip/flip.min.js"></script>
<script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/fontawesome.min.js"></script>
<script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/duotone.min.js"></script>
</body>

</html>