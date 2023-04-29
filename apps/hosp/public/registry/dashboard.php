

<?php 
include 'registry.controller.php';
$q = new RegistryModel();
R::selectDatabase('SOCIALENTITY');


$totalCluster = $q->GetTotalCluster()[0]['total'];

?>

<style type="text/css">
    .ir-table {
        margin-top: 30px;
    }
    .card {
        text-align: center;
    }
    .card-title {
        font-weight: 700;
    }
    .card-text {
        font-weight: 700;
        font-size: 2em;
    }
</style>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm">
        <div class="card text-white bg-warning mb-3" onclick="getClusterList()" style="cursor:pointer; min-height:9rem; max-width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">CLARIN-TUDELA CLUSTER</h5>
            <p class="card-text" id="totalcluster">
                <?= $totalCluster; ?>
            </p>
          </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card text-white bg-warning mb-3" style="cursor:pointer; min-height:9rem; max-width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">TUDELA VALIDATED</h5>
            <p class="card-text" id="valid-tudela">
                0
            </p>
          </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card text-white bg-warning mb-3" style="cursor:pointer; min-height:9rem; max-width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">CLARIN VALIDATED</h5>
            <p class="card-text" id="valid-clarin">
                0
            </p>
          </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card text-white bg-warning mb-3" style="cursor:pointer; min-height:9rem; max-width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">NEW</h5>
            <p class="card-text">
                0
            </p>
          </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card text-white bg-warning mb-3" style="cursor:pointer; min-height:9rem; max-width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">UNCLAIMED</h5>
            <p class="card-text">
                0
            </p>
          </div>
        </div>
    </div>
  </div>
</div>
<div class="table-responsive ir-table">
    <div class="table-responsive">
        <table class="table" id="validated">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Ext</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Barangay</th>
                    <th>City/Municipality</th>
                    <th>Teller</th>
                    <th>Verified</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script>
    function getClusterList() {
        $.get('?page=registry&ds=api&method=get&action=clusterlist', function(data) {
             $("#toolbox").load( "?page=registry&form=form.search.entity", function() {
                $('.modal').modal('show');
           });
        });
    }
    function getValidatedData() {
        $.get( "?page=registry&ds=api&method=get&action=verified", function( data ) {
          // $( "#valid-tudela" ).html( data );
          $("table#validated tbody").empty();
          $(data).each(function(index, el) {
              if (data.length > 0) {
                    var fullname = el.last_name + ", " + el.first_name + " " + el.middle_name; 
                    var currentClass = "";
                    var dupeClass = "";
                    let ivals = 0;
                    var currentDate = new Date();
                    var birthdate = new Date(el.birthdate);

                    var trdata =  $("<tr class='"+currentClass+"'  id=\"id\" data-clipboard-text=\""+el.idno+"\">"+
                        "<td>"+(index+1)+"</td>"+
                        "<td>"+el.idno+"</td>"+
                        "<td class='"+dupeClass+"' >"+ el.last_name +"</td><td class='"+dupeClass+"' >"+ el.first_name +"</td><td class='"+dupeClass+"' >"+ el.middle_name +"</td>"+
                        "<td class='"+dupeClass+"'>"+ (el.suffix != null ? el.suffix : "") +"</td>"+
                        "<td>"+(currentDate.getFullYear()-birthdate.getFullYear())+"</td>"+
                        "<td class='"+el.status.toLowerCase()+"'>"+el.status+"</td>"+
                        "<td>"+el.barangay+"</td>"+
                        "<td>"+el.citymun+"</td>"+
                        "<td>Teller "+el.teller_code+"</td>"+
                        // "<td>"+(new Date(el.patbdate).toISOString().split('T')[0])+"</td>"+
                        // "<td>"+getFormattedDate(new Date(el.patbdate))+"</td>"+
                        // "<td>"+moment(new Date(el.patbdate)).format('LLL')+"</td>"+
                        // "<td>"+moment(new Date(el.admdate)).format('LLL')+"</td>"+

                        "<td><i title=\"Validated\" class=\"fa-duotone fa-thumbs-up orange-accent\"  style=\"font-size: 15pt;\"></i></td>"+
                        "</tr>");


                    $(trdata).click(function(event) {
                        var btn = document.querySelector('#id');

                        $(this).addClass('highlight-row').delay(4000).queue(function(){
                            $(this).removeClass('highlight-row').dequeue();
                        });

                        btn.addEventListener('click', () => {
                        const textCopied = ClipboardJS.copy(el.idno);
                        });
                        $(".toast-body").html("Patient <b>[" + el.idno + "]</b> " + fullname + " <br> Hospital ID copied to clipboard");

                        $('.toast').toast('show');

                    });
                    $(trdata).appendTo("#validated tbody");
                    dupeName = el.last_name + ", " + el.first_name + " " + el.middle_name; 
                } else {
                    $("#printable tbody").empty();
                }  
          });
          // console.log(data);
        });
        $.get( "?page=registry&ds=api&method=get&action=tudelaverified", function( data ) {
          $( "#valid-tudela" ).html( data );
        });
        $.get( "?page=registry&ds=api&method=get&action=clarinverified", function( data ) {
          $( "#valid-clarin" ).html( data );
        });
    }
    setInterval(function() {
        getValidatedData();
    },1000);
</script>