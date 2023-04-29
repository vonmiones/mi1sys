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
            <?php foreach (GetEntities() as $entity): ?>            
                <tr>
                    <td></td>
                    <td><?= trim($entity['LASTNAME']) . "," .  trim($entity['FIRSTNAME']) . " " .  substr($entity['MIDDLENAME'],0,1) . "." . ((trim($entity['SUFFIX']) != null)? $entity['SUFFIX']:"")  ; ?></td>
                    <td><?= $entity['OFFICE']; ?></td>
                    <td>
                        <a id="account-create" data-id="<?= trim($entity['objid']); ?>">
                        <i class="fa-duotone fa-user-shield" style="--fa-primary-color: #4e73df; --fa-secondary-color: dimgray;"></i>
                        </a> 
                        <a href="?route=admin&page=account&fn=roles">
                            <i class="fa-duotone fa-key"  style="--fa-primary-color: #4e73df; --fa-secondary-color: dimgray;"></i>
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
        $(el).on('click',function(event) {
            event.preventDefault();
            var data = {id:$(this).data("id")};
            $("#toolbox").load( "?route=admin&page=account&form=register.user",data, function() {
                $('.modal').modal('show');
           });
        }); 
    });


} );
</script>