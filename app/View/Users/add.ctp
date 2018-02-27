<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header_add'); ?>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            
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
		<div class="users form">
			<?php echo $this->Form->create('User',array('type' => 'file')); ?>
		
				<legend><?php echo __('Đăng kí người dùng mới'); ?></legend>
				<table style="width:1000px">
					<tr>
						<td style="width: 510px">
							<h4>Đăng kí miễn phí một tài khoản trên MoneyLover</h4>
							<h5>Tận hưởng lợi ích mà MoneyLover đem lại cho bạn</h5>
							<?php echo $this->Html->image('/img/money-icon.jpg', array('width' => 500, 'height' => 300)); ?>
						</td>
						<td>
						<legend>Phần thông tin tài khoản</legend>
						<?php echo $this->Form->input('username', array('label'=>'Tên tài khoản', 'class'=>"form-control", 'placeholder' => 'Tên tài khoản')); ?>
						<?php echo $this->Form->input('password', array('label'=>'Tạo mật khẩu (Tối thiểu 8 kí tự)', 'class'=>"form-control", 'placeholder'=>" Mật khẩu")); ?>
						<?php echo $this->Form->input('confirm_password', array('label'=>'Xác nhận mật khẩu', 'class'=>"form-control", 'type'=>'password', 'placeholder'=>" Xác nhận mật khẩu")); ?>
						<br><legend>Phần thông tin cá nhân</legend>
						<?php echo $this->Form->input('fullname', array('label'=>' Tên chủ tài khoản', 'class'=>"form-control", 'placeholder' => 'Họ và tên')); ?>
						<?php echo $this->Form->input('email', array('label'=>'Email', 'class'=>"form-control", 'placeholder' => 'Địa chỉ email')); ?>
						<?php echo $this->Form->input('address', array('label'=>' Địa chỉ','class'=>"form-control", 'placeholder'=>" Địa chỉ")); ?>
						<?php echo $this->Form->input('phone', array('label'=>'Số điện thoại', 'class'=>"form-control", 'placeholder' => 'Số điện thoại')); ?><br>
						<?php echo $this->Form->button('Đăng kí',array('type' => 'submit','class'=>'btn btn-primary')); ?>
						<?php echo $this->Html->link('Hủy', array('action' => 'login'), array('class' => 'btn  btn-default')) ?>
						</td>
					</tr>
				</table>
			</br>
			
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</body>
</html>