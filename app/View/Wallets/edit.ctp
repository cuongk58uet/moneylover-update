<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          	<li class="active"><?php echo $this->Html->link(__('Chỉnh sửa ví'), ''); ?> </li>
          	<li><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Form->postLink(__(' Xóa ví'), array('action' => 'delete', $this->Form->value('Wallet.id')), array('confirm' => __(' Bạn có chắc chắn muốn xóa %s?', $this->Form->value('Wallet.wallet_name')))); ?></li>
			<li><?php echo $this->Html->link(__('Trở lại'), array('action' => 'index')); ?></li>
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
		<div class="wallets form">
			<?php echo $this->Form->create('Wallet'); ?>
			<fieldset>
				<legend><?php echo __(' Chỉnh sửa ví'); ?></legend>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('wallet_name', array('label'=>'Tên ví','class'=>"form-control", 'placeholder' => 'Tên ví'));
				echo $this->Form->input('currency',array('label'=>' Đơn vị tiền tệ','class'=>"form-control", 'placeholder' => 'Đơn vị tiền tệ', 'options' => array(
					'VND (₫)' => 'Việt Nam Đồng (₫)',
					'USD ($)' => 'Đô La Mỹ ($)',
					'YEN (¥)' => 'Yên Nhật (¥)',
					'Euro (€)' => 'Euro (€)',
					'Pound (£)' => 'Bảng Anh (£)'
				)));
				echo $this->Form->input('banlances', array('label'=>' Số dư','class'=>"form-control", 'placeholder' => 'Số dư'));
			?>
			</fieldset>
			</br>
			<?php echo $this->Form->button('Lưu thay đổi',array('type' => 'submit','class'=>'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</body>

</html>