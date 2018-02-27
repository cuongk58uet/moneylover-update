<html>
<head>
	
</head>

<body>

<div class ="container">
	<div class="row">
		<?php echo $this->element('header_login'); ?>
	</div>
	<hr>
	<div class="content col-md-4">
	</div>
		<div class="content col-md-4">
		<?php if(empty($this->request->data)) : ?>
			<?php echo $this->Flash->render('authenticate'); ?>
			<?php echo $this->Session->flash('auth'); ?>
		<?php else: ?>
			<?php echo $this->Session->flash('auth'); ?>
		<?php endif ?>
			<div class="panel panel-primary">
				<div class="panel-heading">
	            	<h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Đăng nhập </h3>
            	</div>
	            <div class="panel-body">
	            		<?php echo $this->Html->image('/img/avatar-001.jpg', array('width' => 100, 'height'=>100, 'class'=>'img-circle img-responsive center-block')); ?>
					<div class="users form">
						<?php echo $this->Form->create('User' ); ?>
						<fieldset>
							<?php echo $this->Form->input('username',array('label'=>'Tên đăng nhập','class'=>"form-control", 'placeholder'=>" Tên đăng nhập"));
							echo $this->Form->input('password',array('label'=>'Mật khẩu', 'class'=>'form-control', 'placeholder'=>"Mật khẩu" ));
							?>
							
						</fieldset></br>
						<?php echo $this->Form->button('Đăng nhập',array('type' => 'submit','class'=>'btn btn-primary btn-block')); ?></br>
						
						<?php echo $this->Html->link('Quên mật khẩu?','/quen-mat-khau'); ?></br>
						<?php echo $this->Html->link('Đăng kí mới','/dang-ki', array('class' => 'btn btn-sm btn-default')); ?>
						
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>