<style>
    textarea{
        color: darkgreen;
    }
</style>
<div class="container" style="margin-top:50px;">
        <form class="d-md-flex justify-content-md-center">
            <div class="form-check" style="margin-right: 0px;"><input type="radio" class="form-check-input" id="api1" name="api" value="region" style="margin-right: 0px;" /><label class="form-check-label" for="api1" style="margin-right: 20px;margin-left: -2px;">Region</label></div>
            <div class="form-check" style="margin-right: 0px;"><input type="radio" class="form-check-input" id="api2" name="api" value="province" style="margin-right: 0px;" /><label class="form-check-label" for="api2" style="margin-right: 20px;margin-left: -2px;">Province</label></div>
            <div class="form-check" style="margin-right: 0px;"><input type="radio" class="form-check-input" id="api3" name="api" value="citymunicipality" style="margin-right: 0px;" /><label class="form-check-label" for="api3" style="margin-right: 20px;margin-left: -2px;">City/Municipality</label></div>
            <div class="form-check" style="margin-right: 0px;"><input type="radio" class="form-check-input" id="api4" name="api" value="barangay" /><label class="form-check-label" for="api4" style="margin-right: 20px;margin-left: -2px;">Barangay</label></div>
        </form>
    </section>
    <code class="d-md-flex justify-content-md-center align-items-md-center"><textarea id="apiwrapper" class="form-control-sm d-md-flex flex-grow-1 flex-shrink-1 flex-fill justify-content-md-center align-items-md-center" name="apiwrapper" style="min-height: 300px;"></textarea></code>
</div>
<script>
    $(document).ready(function() {
        $("input[type=radio]").on('click', function(event) {
            var val = $(this).val();
            var uri = "?route=api&page=geoinfo&fn="+val+".info";
            console.log(uri);
            $("#apiwrapper").load(uri, function(json, textStatus) {
                    // $("#apiwrapper").val( );
            });
        });
    });
</script>