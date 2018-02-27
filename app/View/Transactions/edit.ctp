<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          	<li class="active"><?php echo $this->Html->link(__('Sửa giao dịch'), ''); ?></li>
            <li><?php echo $this->Form->postLink(__(' Xóa giao dịch'), array('action' => 'delete', $this->Form->value('Transaction.id')), array('confirm' => __(' Bạn có chắc chắn muốn xóa giao dịch %s?', $this->Form->value('Transaction.id')))); ?></li>
            <li><?php echo $this->Html->link(__(' Danh mục ví'), array('controller' => 'wallets', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('Trở về'), array('action' => 'index')); ?></li>
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
		<div class="transactions form">
			<?php echo $this->Form->create('Transaction'); ?>
			<fieldset>
				<legend><?php echo __('Sửa giao dịch'); ?></legend>
			
				<?php echo $this->Form->input('id'); ?>
				<?php echo $this->Form->input('amount',array('label'=>'Giá trị','class'=>"form-control", 'placeholder' => 'Giá trị')); ?></br>
				<table>
					<tr>
						<th>Ngày giao dịch: </th>
						<td style="padding:0px">
							<?php echo $this->Form->day('create_date', array(
								'class' => 'form-control',
								'empty' => false
							)); ?>
						</td>
						<td style="padding:2px">
							<?php echo $this->Form->month('create_date', array(
								'class' => 'form-control',
								'monthNames' => array('01' => 'Tháng 1', '02'=> 'Tháng 2', '03'=> 'Tháng 3', '04'=> 'Tháng 4', '05'=> 'Tháng 5', '06'=> 'Tháng 6', '07'=> 'Tháng 7', '08'=> 'Tháng 8', '09'=> 'Tháng 9', '10'=> 'Tháng 10', '11'=> 'Tháng 11', '12' => 'Tháng 12'),
								'empty' => false
							)); ?>
						</td>
						<td>
							<?php echo $this->Form->year('create_date', date('Y')-5, date('Y')+5, array(
							'class' => 'form-control',
							'empty' => false
							)); ?>
						</td>
					</tr>
				</table>
				<?php echo $this->Form->error('create_date'); ?>
				<?php echo $this->Form->input('note',array('label'=>' Ghi chú','class'=>"form-control", 'placeholder' => 'Ghi chú')); ?>
				<?php echo $this->Form->input('wallet_id',array('label'=>' Ví','class'=>"form-control")); ?>
				<?php echo $this->Form->input('category_id',array('label'=>'Danh mục','class'=>"form-control")); ?>
			</fieldset>
			</br>
			<?php echo $this->Form->button('Lưu thay đổi',array('type' => 'submit','class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link(__('Hủy thay đổi'), array('controller' => 'transactions', 'action' => 'index'), array('class' => 'btn btn-default')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</body>

</html>