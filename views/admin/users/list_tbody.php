<?php foreach ($users as $user): ?>
<tr>
    <td><?= $user->id ?></td>
    <td><?= HTML::anchor($request->uri(array('action'=>'view','id'=>$user->id)),$user->username) ?></td>
	<td><?= $user->role ?></td>
    <td><?= $user->email ?></td>
    <td><?= HTML::anchor($request->uri(array('action'=>'edit','id'=>$user->id)),"Edit", array('class'=>'edit')) ?></td>
    <td><?= HTML::anchor($request->uri(array('action'=>'delete','id'=>$user->id)),"Supprimer", array('class'=>'delete')) ?></td>
</tr>
<?php endforeach ?>
