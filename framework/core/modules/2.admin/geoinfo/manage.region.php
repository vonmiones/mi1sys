<div style="margin-top:20px;">
    <table id="userlist" class="display" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Code</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (GetRegions() as $entity): ?>            
                <tr>
                    <td></td>
                    <td><?= zpad($entity['REG_ID'],2); ?></td>
                    <td><?= str_replace('_', ' ',$entity['DESCRIPTION']); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Code</th>
                <th>Name</th>
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
} );
</script>