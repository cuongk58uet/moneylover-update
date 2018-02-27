<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

<title>
	<?php echo $title_for_layout; ?>
</title>

<?php
	echo $this->Html->meta('icon');
	
	echo $this->Html->css('bootstrap.min');
	echo $this->Html->css('dashboard');
	echo $this->Html->css('font-awesome');
	
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body>
	<div class="container-fluid" style="height:500px">
		<div class="row">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>

	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<!-- <?php echo $this->element('sql_dump'); ?> -->
	</div>		
	<?php echo $this->Html->script('jquery'); ?>
	<?php echo $this->Html->script('bootstrap'); ?>
	<?php echo $this->Html->script('html5shiv'); ?>
</body>
</html>