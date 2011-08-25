<div class="box">
	<h2>Search</h2>
	<p>
<?= Form::open('admin/users/list',array('id'=>'search_form')) ?>
Name :
<?= Form::input('username',Arr::get($_POST,'username')) ?>
<br>
<?= Form::submit('','Find').Form::close() ?>

		<ul>
<?php if (isset($links)): ?>
	<li><?php echo __('Quick Links') ?> 
				<ul>
<?php foreach($links as $text=>$link): ?>
					<li><?php echo HTML::anchor($link, $text) ?></li>
<?php endforeach; ?>
				</ul>
			</li>
<?php endif; ?>
		</ul>
	</p>
</div>
