<!DOCTYPE html>
<head>
	
</head>

<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
		<ul class="nav nav-sidebar">
			<li class="active"><?php echo $this->Html->link(__('Về chúng tôi'), ''); ?> </li>
		<li><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
		</ul>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="col-lg-12">
            <h2 class="page-header">Về chúng tôi</h2>
        </div>
        <div class="col-lg-4 col-sm-6 text-center">
            <?php echo $this->Html->image('/img/default_avatar.png', array('width' => 200, 'height' => 200, 'class'=> 'img-circle img-center')); ?>
            <h3>Nguyễn Mạnh Cường
                <small>K58-UET</small>
            </h3>
            <b>Email: </b>cuongnm_58@vnu.edu.vn
            <h4><small>DEVELOPMENT TEAM</small></h4>
        </div>
        <div class="col-lg-4 col-sm-6 text-center">
            
            <?php echo $this->Html->image('/img/default_avatar.png', array('width' => 200, 'height' => 200, 'class'=> 'img-circle img-center')); ?>
            <h3>Kiều Trọng Vĩnh
                <small>K58-UET</small>
            </h3>
            <b>Email: </b>vinhkt_58@vnu.edu.vn
            <h4><small>DEVELOPMENT TEAM</small></h4>
        </div>
	</div>
</body>

</html>