<!DOCTYPE html>
<head>
	
</head>
<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
		<ul class="nav nav-sidebar">
			<li class="active"><?php echo $this->Html->link(__('Liên hệ'), ''); ?> </li>
		<li><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
		</ul>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<?php if($this->Session->check('Message.success')): ?>
			<div class="alert alert-info">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<?php echo $this->Session->flash('success'); ?>
			</div>
		<?php else: ?>
		<?php if($this->Session->check('Message.error')): ?>
			<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<?php echo $this->Session->flash('error'); ?>
			</div>
		<?php endif ?>
		<?php endif ?>
		<?php echo $this->Form->create(); ?>
			<fieldset>
			<h4>Phản hồi</h4>
					<?php echo $this->Form->input('email', array('label' =>'', 'type'=>'textarea', 'cols' => 100)); ?>
			</fieldset>
			</br>
			<?php echo $this->Form->button('Gửi phản hồi',array('type' => 'submit','class'=>'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
	</div>
</body>
</html>