<!DOCTYPE html>
<html>
<body>
	
</body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
	          <ul class="nav nav-sidebar">
	          	<li class="active"><?php echo $this->Html->link(__('Chi tiết danh mục'), ''); ?> </li>
	            <li><?php echo $this->Html->link(__('Sửa danh mục'), '/chinh-sua-danh-muc/'.$category['Category']['id']); ?> </li>
				<li><?php echo $this->Form->postLink(__(' Xóa danh mục'), array('action' => 'delete', $category['Category']['id']), array('confirm' => __(' Bạn có chắc chắn muốn xóa danh mục %s?', $category['Category']['category_name']))); ?> </li>
				<li><?php echo $this->Html->link(__(' Trở về'), array('action' => 'index')); ?> </li>
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
		<div class="panel panel-primary">
			<div class="panel-heading">
      			<h3 class="panel-title"><?php echo __(' Chi tiết danh mục'); ?></h3>
    		</div>
			<div class="panel-body">
				<div class="categories view">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td rowspan="2" style="width:200px"><?php echo $this->Html->image('/img/'.$category['Category']['category_type'].'.jpg', array('width'=>150, 'height' => 150, 'class' => ' img-circle ')); ?></td>
								<th style="width:150px"><?php echo __(' Tên danh mục:'); ?></th>
								<td><?php echo h($category['Category']['category_name']); ?></td>
							</tr>
							<tr>
								<th><?php echo __(' Loại danh mục:'); ?></th>
								<th><?php echo h($category['Category']['category_type']); ?></th>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</html>