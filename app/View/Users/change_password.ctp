<html>
<head>
	
</head>

<body>
<div class ="container">
	<div class="row">
		<?php echo $this->element('header'); ?>
	</div>
	<hr>
	<div class="content col-md-4">
	</div>
		<div class="content col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
	            	<h2 class="panel-title"><strong class="glyphicon glyphicon-user"></strong> Đổi mật khẩu</h2>
	            </div>
	            <div class="panel-body">
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
					<?php echo $this->element('errors'); ?>
					<div class="users form">

						<?php echo $this->Form->create('User' ); ?>
						<fieldset>
							<?php echo $this->Form->input('password',array('label'=>' Mật khẩu mới(Tối thiểu 8 kí tự)','class'=>"form-control", 'placeholder'=>" Mật khẩu mới"));
							echo $this->Form->input('confirm_password',array('label'=>' Xác nhận mật khẩu', 'class'=>'form-control', 'placeholder'=>" Xác nhận mật khẩu", 'type'=>'password', 'error' => false ));
							?>
							
						</fieldset></br>
						<?php echo $this->Form->button(' Lưu thay đổi',array('type' => '','class'=>'btn btn-lg btn-primary btn-block')); ?></br>
						<?php echo $this->Html->link(__('Hủy thay đổi'), array('controller'=>'transactions', 'action' => 'index'),array('class' => 'btn btn-default')); ?>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>