<!DOCTYPE html>
<html>
<head>
	
</head>

<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
          		<ul class="nav nav-sidebar">
          		<li><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
          		<li class="active"><?php echo $this->Html->link(__('Thông tin cá nhân'), ''); ?> </li>
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
			<div class="users view" >
				<div class="panel panel-primary">
					<div class="panel-heading">
              			<h3 class="panel-title"><?php echo __(' Thông tin cá nhân'); ?></h3>
            		</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td rowspan="6" style="width:200px"><?php echo $this->Html->image($user['User']['avatar'],array('width'=>200, 'height' => 200, 'class' => 'img-rounded img-circle ')); ?></td>
									<th style="width:30px"><?php echo __('Tài Khoản:'); ?></th>
									<th><?php echo h($user['User']['username']); ?></th>
								</tr>
								<tr>
									<th><?php echo __('Chủ tài khoản:'); ?></th>
									<td><?php echo h($user['User']['fullname']); ?></td>
								</tr>
								<tr>
									<th><?php echo __(' Địa chỉ:'); ?></th>
									<td><?php echo h($user['User']['address']); ?></td>
								</tr>
								<tr>
									<th><?php echo __('Email:'); ?></th>
									<td><?php echo h($user['User']['email']); ?></td>
								</tr>
								<tr>
									<th><?php echo __('Số điện thoại:'); ?></th>
									<td><?php echo h($user['User']['phone']); ?></td>
								</tr>
								<tr>
									<td><?php echo $this->Html->link(__(' Chỉnh sửa thông tin'), '/cap-nhat-thong-tin', array('class' => 'btn btn-primary')); ?></td>
									<td></td>
								</tr>
								
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	

</body>

</html>