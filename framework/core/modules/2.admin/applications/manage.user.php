<div style="margin-top:20px;">
    <table id="userlist" class="display" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Entity</th>
                <th>Username</th>
                <th>Password</th>
                <th>Group</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (GetLoginAccounts() as $account): ?>            
                <tr>
                    <td></td>
                    <td><?= $account['entity']; ?></td>
                    <td><?= $account['user']; ?></td>
                    <td><?= md5($account['pass']); ?></td>
                    <td><?= $account['login_state']; ?></td>
                    <td><?= $account['dt_created']; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Entity</th>
                <th>Username</th>
                <th>Password</th>
                <th>Group</th>
                <th>Date Created</th>
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