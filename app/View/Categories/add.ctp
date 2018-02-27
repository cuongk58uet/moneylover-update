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
			<li class="active"><?php echo $this->Html->link(__('Thêm danh mục'), ''); ?> </li>
			<li><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('Các danh mục'), array('action' => 'index')); ?></li>
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
		<?php echo $this->Form->create('Category'); ?>
		<fieldset>
			<legend><?php echo __('Thêm danh mục'); ?></legend>
				<?php
					echo $this->Form->input('category_name',array('label'=>'Tên danh mục mới','class'=>"form-control", 'placeholder'=>" Tên danh mục"));
					echo $this->Form->input('category_type',array('label'=>'Kiểu danh mục','class'=>"form-control", 'options' => array('Nợ' => 'Nợ' , 'Cho Vay' => 'Cho Vay' , 'Chi Tiêu' => 'Chi Tiêu', 'Khoản Thu Nhập' => 'Thu Nhập')));
				?>
		</fieldset>
		</br>
		<?php echo $this->Form->button('Thêm',array('type' => 'submit','class'=>'btn btn-primary')); ?>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>
</body>
</html>
