<style>
  .new{
    background-color: orange!important;
    color: white;
    text-transform: uppercase;
  }
  .region{
    color: red;
  }
  .province{
    color: orange;
  }
  .municipality{
    color: green;
  }
  .barangay{
    color: blue;
  }
</style>
<!-- Module Menu Start -->
<nav class="navbar navbar-expand-lg" style="border-bottom:1px solid ; border-bottom-color: grey;">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">

      <div class="form-group d-flex flex-row flex-grow-1 flex-shrink-1 flex-fill justify-content-center align-items-center align-content-center align-self-center m-auto" style="text-align: center;">
        <input class="form-control" id="search" type="search" name="name" placeholder="Search..." style="min-width: 500px; margin-right:10px;"/>
        <button class="btn btn-primary" style="margin-right:10px;" type="button" id="search-btn">Search</button>
      </div>

    </div>
  </div>
  <span class="form-inline">
      <!-- <button class="btn btn-primary" style="margin-right:10px;" type="button" id="addentry">New Entry</button>  -->
      <button class="btn btn-primary" style="margin-right:10px;" type="button">Generate report</button>
  </span>
</nav>
<!-- Module Menu End -->

 <div class="modal fade"  data-backdrop="static" role="dialog" tabindex="-1" id="toolModal" style="min-width: 800;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button class="btn btn-primary" id="btn-print" type="button">Print Request</button> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="toolbox"></div>
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
        var request;

        $("button#addentry").on('click',function(event) {
            event.preventDefault();
            $("#toolbox").load( "?page=registry&form=registry.newentry", function() {
                $('.modal').modal('show');
           });
        });

        $("button#search").on('click',function(event) {
            event.preventDefault();
            $("#toolbox").load( "?page=registry&form=form.search.entity", function() {
                $('.modal').modal('show');
           });
        });

        $("#btn-save").click(function(event) {

            var subcat = JSON.stringify($("#subcategories").val());
            var jobdetails = $("#joborder").val();
   
            var data = new FormData();
            jQuery.each(jQuery('#fileattachment')[0].files, function(i, file) {
                data.append('file', file);
            });  
            data.append('categoryid', subcat);
            data.append('description', jobdetails);

            $.ajax({
                url: '?page=registry&ds=api', // <-- point to server-side PHP script 
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                timeout: 600000,
                processData: false,
                data: data,                         
                type: 'post',
                success: function(r){
                    $('.modal').modal('hide');
                    location.reload();
                }
             });

        });
    });

$("#search-btn").click(function(event) {
            search();
        });
        function search() {
                    $("#toolbox").load( "?page=registry&form=form.search.entity", function() {
                            $('.modal').modal('show');
                    });            
                $("#printable tbody").empty();
                $.ajax({
                    url: '?page=registry&ds=api',
                    type: 'GET',
                    dataType: 'JSON',
                    data: { name: $("input#search").val() },
                })
                .done(function(e) {    
                    var dupeName = "";
                    $(e.result).each(function(index, el) { 
                        if (e.result.length > 0) {
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

                                "<td><a href=\"?page=registry&ds=api&method=update&action=verified&objid="+el.objid+"\" id=\"validate\"><i class=\"fa-duotone fa-check orange-accent\"  style=\"font-size: 15pt;\"></i></a></td>"+
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
                            $(trdata).appendTo("#printable tbody");
                            dupeName = el.last_name + ", " + el.first_name + " " + el.middle_name; 
                        } else {
                            $("#printable tbody").empty();
                        }
                    });
             });
        }

</script>