
<div style="margin-top:20px;">
    <table id="userlist" class="display" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Entity</th>
                <th>Username</th>
                <th>Email</th>
                <th>Group</th>
                <th>Date Created</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (GetLoginAccounts() as $account): ?>            
                <tr data-id="<?= $account['objid']; ?>" data-entity="<?= $account['entity']; ?>" data-email="<?= $account['email']; ?>" data-user="<?= $account['user']; ?>">
                    <td></td>
                    <td><?= $account['entity']; ?></td>
                    <td><?= $account['user']; ?></td>
                    <td><?= $account['email']; ?></td>
                    <td><?= $account['login_state']; ?></td>
                    <td><?= $account['dt_created']; ?></td>
                    <td>
                        <a  title="Edit Entity" id="edit-entity" ><i class="fa-duotone fa-user-pen"></i></a>
                        <a  title="Login Account" id="login-account" ><i class="fa-duotone fa-key" ></i></a>
                        <a  title="Delete Account" id="delete-entity" ><i class="fa-duotone fa-circle-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Entity</th>
                <th>Username</th>
                <th>Email</th>
                <th>Group</th>
                <th>Date Created</th>
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
            style:    'os', // multi, os
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    } );
} );

$("a#login-account").on('click',function(event) {
    
    let data = {};
    data['id'] = $(this).parent('td').parent('tr').data('id');
    data['entity'] = $(this).parent('td').parent('tr').data('entity');
    data['email'] = $(this).parent('td').parent('tr').data('email');
    data['user'] = $(this).parent('td').parent('tr').data('user');
    console.log(data);
    $("#toolbox").load( "?route=admin&page=account&form=register.user",data, function() {
        $('.modal').modal('show');
   });
});


</script>