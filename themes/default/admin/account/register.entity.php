<div class="container-fluid h-100">
    <div style="margin: 50px;">

        <div class="row">
            <div class="col-3">
                <ul class="nav flex-column">
                    <li class="nav-item" role="presentation"><a href="#" data-target="form.entity.basic.info" onclick="load(this)" class="nav-link" >Basic Information</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Contact and Address</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Family Information</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Documentary Attachments</a></li>
                    <hr>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Education Information</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Employment Information</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Medical Information</a></li>
                    <hr>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >ID and Licenses</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Assets Information</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Equipment and Supplies</a></li>
                    <hr>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Organizational Affiliation</a></li>
                    <li class="nav-item" role="presentation"><a href="#" data-target="" class="nav-link" >Trainings and Seminars</a></li>
                </ul>                
            </div>
            <div class="col">
                    <div class="tab-content">
                        <div class="tab-content-wrapper">
                            
                        </div>
                    </div>                
            </div>
        </div>



    </div>
</div>
<script>
    function load(el) {
        var form = $(el).data("target");
        $(".tab-content-wrapper").empty();
        $(".tab-content-wrapper").load( "?route=admin&page=account&form="+form,function() {
       });
    }

    $("#btn-save").click(function(event) {
        alert("Saved");
        var data = "";
        switch (method) {
            case "newentity":
                    data = {
                        method:"newentity",
                        lastname:$("input#lastname").val(),
                        firstname:$("input#firstname").val(),
                        middlename:$("input#middlename").val(),
                        suffix:$("#suffix").val(),
                        sex:$("input#sex").val(),
                        civilstatus:$("#civilstatus").val(),
                        nationality:$("#nationality").val(),
                        ethnicgroup:$("#ethnicgroup").val(),
                        withchildren:$("input#withchildren").val(),
                        ispwd:$("input#ispwd").val(),
                        isipmember:$("input#isipmember").val(),
                        birthdate:$("input#birthdate").val(),
                        address:$("input#address").val(),
                        bloodtype:$("#bloodtype").val(),
                        height:$("input#height").val(),
                        weight:$("input#weight").val()
                    };
                    $(".tab-content-wrapper").empty();
                    console.log(data);
                break;
        }

        $.ajax({
            url: '?route=admin&page=account&ds=api',
            type: 'POST',
            data: data,
        })
        .done(function(s) {
            console.log("success ");
            console.log(s);
            $('.modal').modal('hide');
        })
        .fail(function(f) {
            console.log("error");
        });
        
    });


</script>