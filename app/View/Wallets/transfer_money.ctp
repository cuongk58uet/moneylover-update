<!DOCTYPE html>
<html>
<head>
	
</head>

<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class=" col-sm-3 col-md-2 sidebar">
		<ul class="nav nav-sidebar">
			<li class="active"><?php echo $this->Html->link(__('Chuyển tiền'), ''); ?> </li>
			<li><?php echo $this->Html->link(__('Trở về'), array('action' => 'index')); ?> </li>
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
		<div class="categories form">
			<?php echo $this->Form->create(); ?>
			<fieldset>
				<legend><?php echo __('Chuyển tiền giữa 2 ví'); ?></legend>
					<?php
						echo $this->Form->input('amount',array('label'=>'Số tiền muốn chuyển','class'=>"form-control", 'placeholder'=>" Số tiền muốn chuyển", 'empty' => 'true'));
						echo $this->Form->input('source_id',array('label'=>'Ví Nguồn','class'=>"form-control"));
						echo $this->Form->input('destination_id',array('label'=>'Ví Đích','class'=>"form-control"));
					?>
			</fieldset>
			</br>
			<?php echo $this->Form->button('Thực hiện chuyển tiền',array('type' => 'submit','class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link('Hủy', array('action' => 'index'), array('class' => 'btn btn-default')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</body>
</html>
