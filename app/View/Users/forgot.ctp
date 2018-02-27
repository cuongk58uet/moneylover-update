<!DOCTYPE html>
<head>
	
</head>
<body>
	<?php echo $this->element('header_login'); ?>
	<hr>
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
		    	<h3 class="panel-title"><strong class="glyphicon glyphicon-user"></strong> Quên mật khẩu </h3>
			</div>
		    <div class="panel-body"> 
				<div class="users form">
					<?php echo $this->Form->create('User' ); ?>
					<fieldset>
						<?php echo $this->Form->input('email',array('label'=>'Vui lòng nhập địa chỉ Email mà bạn đã đăng kí trên  MoneyLover','class'=>"form-control", 'placeholder'=>"Email"));?></br>
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
					</fieldset>
					<?php echo $this->Form->button('Lấy lại mật khẩu',array('type' => 'submit','class'=>'btn btn-primary')); ?>
					<?php echo $this->Html->link('Trở về', array('action' => 'login'), array('class' => 'btn  btn-default')) ?>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>