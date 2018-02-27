<!DOCTYPE html>
<html>

<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          	<li><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'transactions', 'action' => 'index')); ?></li>
          	<li class="active"><?php echo $this->Html->link('Chỉnh sửa thông tin', ''); ?></li>
			<li><?php echo $this->Html->link(' Quay lại', array('action' => 'view')); ?></li>
          </ul>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="users form">
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
			
			<?php echo $this->Form->create('User',array('type' => 'file')); ?>
			<fieldset>
				<legend><?php echo __('Chỉnh sửa thông tin'); ?></legend>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<td rowspan="7" style="width:200px">
								<?php echo $this->Html->image($this->request->data['User']['avatar'], array('width'=>200, 'height' => 200, 'class' => 'img-rounded img-circle')); ?>
								<?php echo $this->Form->input('avatar', array('label'=> 'Ảnh đại diện', 'class'=>'img-thumbnail', 'type' => 'file')); ?><br>
								<?php echo $this->Html->link(__('Phục hồi ảnh mặc định'), array('action' => 'delete_avatar'), array('class'=>'btn btn-success')); ?>
							</td>
							<?php echo $this->Form->hidden('id'); ?>
							<?php echo $this->Form->hidden('username'); ?>
							
						</tr>
						<tr>
							<td><?php echo $this->Form->input('fullname', array('label'=>'Họ và tên','class'=>"form-control")); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->input('address', array('label'=>' Địa chỉ','class'=>"form-control")); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->input('email', array('label'=>'Email','class'=>"form-control")); ?></td>
						</tr>
						<tr>
							<td><?php echo $this->Form->input('phone', array('label'=>'Số điện thoại','class'=>"form-control")); ?></td>
						</tr>
						<tr>
							<?php echo $this->Form->input('role', array('label'=>' Quyền','class'=>"form-control", 'options' => array('admin' => 'Admin'), 'type' => 'hidden')); ?>
						</tr>
						<tr>
							<td><?php echo $this->Form->button('Lưu thay đổi',array('type' => 'submit','class'=>'btn btn-primary')); ?>
							</td>
						</tr>
					</table>
				</div>
			
			</fieldset>
			</br>
			
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</body>


</html>