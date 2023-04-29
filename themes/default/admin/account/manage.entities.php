<div style="margin-top:20px;">
    <table id="userlist" class="display" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Entity</th>
                <th>Department</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php $token = new NameTokenizer(); ?>
            <?php foreach (GetEntities() as $entity): ?>            
                <tr id="entity-name"
                    data-first="<?php echo  trim($token->FormName($entity['firstname'],'decrypt')); ?>" 
                    data-middle="<?php echo  trim($token->FormName($entity['middlename'],'decrypt')); ?>" 
                    data-last="<?php echo  trim($token->FormName($entity['lastname'],'decrypt')); ?>" 
                    data-name="<?= trim($token->FormName($entity['lastname'],'decrypt')) . "," .  trim($token->FormName($entity['firstname'],'decrypt')) . " " .  substr($token->FormName($entity['middlename'],'decrypt'),0,1) . "." . ((trim($token->FormName($entity['suffix'],'decrypt')) != null)? $token->FormName($entity['suffix'],'decrypt'):"")  ; ?>" 
                    data-object="<?= trim($token->FormName($entity['objid'])); ?>"
                >
                    <td></td>
                    <td><?= trim($token->FormName($entity['lastname'],'decrypt')) . "," .  trim($token->FormName($entity['firstname'],'decrypt')) . " " .  substr($token->FormName($entity['middlename'],'decrypt'),0,1) . "." . ((trim($token->FormName($entity['suffix'],'decrypt')) != null)? $token->FormName($entity['suffix'],'decrypt'):"")  ; ?></td>
                    <td><?= $token->FormName($entity['office'],'decrypt'); ?></td>
                    <td>
                        <a  style="cursor: pointer;" onclick="createAccount(this)" id="account-create">
                           <i class="fa-duotone fa-user-shield orange-accent"></i>
                        </a> 
                        <a  onclick="updateRole(this)" style="cursor: pointer;">
                            <i class="fa-duotone fa-key orange-accent" ></i>
                        </a>
                        <a  onclick="deleteAccount(this)" style="cursor: pointer;">
                            <i class="fa-duotone fa-trash orange-accent" ></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Entity</th>
                <th>Department</th>
                <th>Options</th>
            </tr>
        </tfoot>
    </table>
</div>


<script>
var method = "";
function createAccount(el) {
    method = "saveAccount";

    var data = {
        object:$(el).parents('tr').data("object"),
        first:$(el).parents('tr').data("first"),
        middle:$(el).parents('tr').data("middle"),
        last:$(el).parents('tr').data("last"),
        fullname:$(el).parents('tr').data("name")
    };
    $("#toolbox").load( "?route=admin&page=account&form=form.user",data, function() {
        $('.modal').modal('show');
   });
}

function updateRole(el) {
    method = "saveRole";
    var data = {
        object:$(el).parents('tr').data("object"),
        first:$(el).parents('tr').data("first"),
        middle:$(el).parents('tr').data("middle"),
        last:$(el).parents('tr').data("last"),
        fullname:$(el).parents('tr').data("name")
    };
    $("#toolbox").load( "?route=admin&page=account&form=form.user.roles",data, function() {
        $('.modal').modal('show');
   });
}

function deleteAccount(el) {
    method = "deleteAccount";
    var data = {
        method:method,
        object:$(el).parents('tr').data("object"),
    };

    $.ajax({
        url: '?route=admin&page=account&ds=api',
        type: 'POST',
        data: data,
    })
    .done(function(s) {
        console.log("success:");
        console.log(s);
        $('.modal').modal('hide');
    })
    .fail(function(f) {
        console.log("error");
    });

}

$(document).ready(function() {

    $('#userlist').DataTable( {
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    } );



    $("a#account-create").each(function(index, el) {
       
    });

    $("#btn-save").click(function(event) {
        switch (method) {
            case "saveAccount":
                    var data = {
                        method:"saveAccount",
                        object:$("#object").val(),
                        entity:$("#fullname").val(),
                        user:$("#username").val(),
                        pass:$("#password").val(),
                        email:$("#email").val(),
                        role:$("#accountroles").find(":selected").val()
                    };
                break;
            case "saveRole":
                    var appids = [];
                    var appnames = [];
                    $('input#selected-app[type=checkbox]:checked').each(function(i){
                        appids[i] = $(this).val();
                        appnames[i] = $(this).data("name");
                    });
                    var data = {
                        method:"saveRole",
                        role:$('input#selected-role[name=role]:checked').val(),
                        appids:JSON.stringify(appids),
                        appnames:JSON.stringify(appnames),
                        object:$("#object").val()
                    };

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

    $("#btn-update").click(function(event) {
        switch (method) {
            case "saveAccount":
                    var data = {
                        action:$("#action").val(),
                        method:"saveAccount",
                        object:$("#object").val(),
                        entity:$("#fullname").val(),
                        user:$("#username").val(),
                        pass:$("#password").val(),
                        email:$("#email").val()
                    };

                break;
            case "saveRole":
                    var appids = [];
                    var appnames = [];
                    $('input#selected-app[type=checkbox]:checked').each(function(i){
                        appids[i] = $(this).val();
                        appnames[i] = $(this).data("name");
                    });
                    var data = {
                        action:$("#action").val(),
                        method:"saveRole",
                        role:$('input#selected-role[name=role]:checked').val(),
                        appids:JSON.stringify(appids),
                        appnames:JSON.stringify(appnames),
                        object:$("#object").val()
                    };
                break;
        }

        console.log(data);

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



} );
</script>