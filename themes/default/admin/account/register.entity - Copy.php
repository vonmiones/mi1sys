<section class="d-xl-flex flex-fill justify-content-center align-items-center align-content-center justify-content-xl-center align-items-xl-start" style="margin: 0 auto;">
    <div class="flex-fill justify-content-center align-items-center align-content-center align-self-center m-auto" style="max-width: 800px;padding: 10px;">
        <ul role="tablist" class="nav nav-pills nav-fill">
            <li role="presentation" class="nav-item"><a role="tab" data-toggle="pill" class="nav-link active" href="#tab-1"><i class="fa-duotone fa-user-tag"></i> PERSONAL DETAILS</a></li>
            <li role="presentation" class="nav-item"><a role="tab" data-toggle="pill" class="nav-link" href="#tab-2"><i class="fa-duotone fa-map-location-dot"></i> CONTACT AND ADDRESS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade show active" id="tab-1">
                <div class="d-xl-flex flex-fill form-container">
                    <form class="flex-fill" method="post" style="max-width: 700px;margin: 0 auto;">
                        <h3 class="text-center text-primary" style="margin-top: 30px;"><strong>PERSONAL</strong>DETAILS</h3>
                        <div class="form-group d-md-flex justify-content-md-center">
                        <input id="lastname" type="text" class="form-control" placeholder="Last Name" name="lastname" style="border-style: none;border-bottom: 1px solid var(--blue) ;" />
                        ,
                        <input id="firstname" type="text" class="form-control" placeholder="First Name" name="firstname" style="border-style: none;border-bottom: 1px solid var(--blue) ;" />
                        ,
                        <input id="middlename" type="text" class="form-control" placeholder="Middle Name" name="middlename" style="border-style: none;border-bottom: 1px solid var(--blue) ;" />
                        ,
                        <select id="namesuffix" class="form-control" name="namesuffix" style="border-style: none;border-bottom: 1px solid var(--blue) ;">
                                <optgroup label="Name Suffix">
                                    <option value>None</option>
                                    <option value="JR">Junior</option>
                                    <option value="SR">Senior</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>
                                    <option value="VII">VII</option>
                                    <option value="VIII">VIII</option>
                                    <option value="X">X</option>
                                </optgroup>
                            </select></div>
                        <div class="form-group text-center text-sm-center text-md-center text-lg-center text-xl-center d-md-flex d-xl-flex justify-content-md-center justify-content-xl-center align-items-xl-center">
                            <div class="custom-control custom-control-inline custom-radio" style="margin: 5;">
                                <input type="radio" class="custom-control-input" id="formCheck-1" name="rdgender" style="margin: 5;" /><label class="custom-control-label" for="formCheck-1" style="margin: 5;">MALE</label></div>
                            <div class="custom-control custom-control-inline custom-radio" style="margin: 5;">
                                <input type="radio" class="custom-control-input" id="formCheck-2" name="rdgender" /><label class="custom-control-label" for="formCheck-2">FEMALE</label></div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="formCheck-3" /><label class="custom-control-label" for="formCheck-3" style="margin-right: 10px;">Person With Disability</label></div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="formCheck-4" /><label class="custom-control-label" for="formCheck-4">IP member<br /></label></div>
                            <section></section>
                        </div>
                        <div class="form-group"><label>Birth Date</label>
                        <input class="form-control" type="date" name="birthdate" style="border-style: none;border-bottom: 1px solid var(--blue) ;" /></div>
                        <section>
                            <div class="form-group d-md-flex" style="padding: 20px;background: rgb(244,244,244);"><label style="margin-right: 5;margin-left: 10px;min-width: 200px;">Valid ID Type<select class="form-control">
                                        <optgroup label="Government Issued ID">
                                            <option value="12" selected>Passport</option>
                                            <option value="13">UMID</option>
                                            <option value="14">Driver&#39;s License</option>
                                        </optgroup>
                                        <optgroup label="Government Issued Document">
                                            <option value="14">PSA Birth Ceritificate</option>
                                            <option value="14">PSA Married Certificate</option>
                                        </optgroup>
                                    </select></label><label style="margin-right: 10px;margin-left: 10px;min-width: 200px;">Valid ID Detail
                                    <input type="text" class="form-control" style="margin-right: 10px;margin-left: 10px;" placeholder="ID Number, Code, Serial" /></label><label style="margin-right: 10px;margin-left: 10px;min-width: 300px;">ID Attachment
                                    <input type="file" class="form-control-file" required /></label></div>
                        </section>
                    </form>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab-2">
                <form style="margin-top: 20px;">
                    <fieldset class="d-md-flex justify-content-md-center">
                        <legend style="color: var(--blue);border-bottom-width: 1px;border-bottom-color: var(--blue);">Contact Details</legend>
                        <div class="form-group d-flex align-content-center justify-content-xl-center" style="border-bottom-width: 1px;border-bottom-color: var(--blue);">
                        <input type="text" class="form-control" id="telno" placeholder="Telephone Number (required)" name="contactnumber" required style="margin: 5px;border-width: 0;border-bottom-width: 1px;border-bottom-color: var(--blue);min-width: 250px;" minlength="5" maxlength="15" />
                    <input type="text" class="form-control" id="contno" placeholder="Mobile Number (required)" name="contactnumber" required style="margin: 5px;border-width: 0;border-bottom-width: 1px;border-bottom-color: var(--blue);min-width: 250px;" minlength="5" maxlength="15" />
                    <input type="email" class="form-control" id="contno-1" placeholder="Email (optional)" name="email" required style="margin: 5px;border-width: 0;border-bottom-width: 1px;border-bottom-color: var(--blue);min-width: 250px;" minlength="5" maxlength="11" /></div>
                    </fieldset>
                    <fieldset>
                        <legend style="color: var(--blue);border-bottom-width: 1px;border-bottom-color: var(--blue);">Address</legend>
                        <div class="custom-control custom-switch" style="margin: 10px;">
                        <input type="checkbox" class="custom-control-input" id="formCheck-5" /><label class="custom-control-label" for="formCheck-5">Permanent Address</label></div>
                        <div class="form-group d-flex flex-row flex-grow-1 flex-shrink-1 flex-fill justify-content-center align-items-center align-content-center align-self-center m-auto" style="text-align: center;"><select class="custom-select" id="region" name="region" style="max-width: 150px;margin: 2px;border-style: none;border-bottom: 1px solid var(--blue) ;" required>
                            </select><select class="custom-select" id="province" name="province" style="max-width: 200px;margin: 2px;border-style: none;border-bottom: 1px solid var(--blue) ;" required>
                                <optgroup label="Region 10" id="province-group">
                                </optgroup>
                            </select><select class="custom-select" id="citymun" name="citymun" style="max-width: 200px;margin: 2px;border-style: none;border-bottom: 1px solid var(--blue) ;" required>
                                <optgroup label="Misamis Occidental" id="citymun-group">
                                </optgroup>
                            </select><select class="custom-select" id="barangay" required name="barangay" style="margin: 2px;max-width: 200px;border-style: none;border-bottom: 1px solid var(--blue) ;">
                                <optgroup label="Barangay" id="barangay-group">
                                </optgroup>
                            </select></div>
                        <div class="form-group d-flex flex-row flex-grow-1 flex-shrink-1 flex-fill justify-content-center align-items-center align-content-center align-self-center m-auto" style="text-align: center;"><textarea class="form-control form-control-sm" name="purok" placeholder="Street, Subdivision, Block, House" rows="3" style="margin: 10px;"></textarea></div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $("#btnSave").click(function(event) {

        var data = {
            method:"newentity",
            firstname:$("#firstname").val(),
            middlename:$("#middlename").val(),
            lastname:$("#lastname").val(),
            namesuffix:$("#namesuffix").val(),
            office:$("#email").val(),
            gender:$("input[name=rdgender").val();
            birthdate:$("input[name=birthdate").val();
        };

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
    function loadRegion() {
        $.getJSON('?route=api&page=geoinfo&fn=region.info', function(json, textStatus) {
               $.each(json, function(index, val) {
                    var REGION = 10;
                    if (val.NATIONAL_CODE == REGION) {
                        $('<option>'+val.DESCRIPTION+'</option>').attr({
                            value: val.NATIONAL_CODE,
                            'data-code': val.NATIONAL_CODE
                        }).appendTo("#region");
                    }
               });
        });
    }
    function loadProvince() {
        $.getJSON('?route=api&page=geoinfo&fn=province.info', function(json, textStatus) {
               $.each(json, function(index, val) {
                    var REGION = 10;
                    if (val.REG_ID == REGION) {
                        $('<option>'+val.DESCRIPTION.replace('_',' ')+'</option>').attr({
                            value: val.PROV_ID,
                            'data-code': val.NATIONAL_CODE
                        }).appendTo("#province-group");
                    }
               });
        });
    }
    function loadCityMun(code) {
        $.getJSON('?route=api&page=geoinfo&fn=citymunicipality.info', function(json, textStatus) {
                $("#citymun-group").children().remove();
                $.each(json, function(index, val) {
                    if (val.PROV_ID == code) {
                        $('<option>'+val.DESCRIPTION+'</option>').attr({
                            value: val.CITYMUN_ID,
                            'data-code': val.NATIONAL_CODE
                        }).appendTo("#citymun-group");
                    }
                });
        });
    }
    function loadBarangay(code) {
        $.getJSON('?route=api&page=geoinfo&fn=barangay.info', function(json, textStatus) {
                $("#barangay-group").children().remove();
                $.each(json, function(index, val) {
                   if (val.CITYMUN_ID == code) {
                        $('<option>'+  val.DESCRIPTION.replace('_',' ') +'</option>').attr({
                            value: val.BARANGAY_ID,
                            'data-code': val.NATIONAL_CODE
                        }).appendTo("#barangay-group");
                    }
                });
        });
    }
    $(document).ready(function() {
        loadRegion(); 
        loadProvince();
        $("#province").on('change', function(event) {
            loadCityMun($(":selected",this).val());
        });
        $("#citymun").on('change', function(event) {
            loadBarangay($(":selected",this).val());
        });
    });
</script>