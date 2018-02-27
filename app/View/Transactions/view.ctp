<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><?php echo $this->Html->link(__('Chi tiết giao dịch'),''); ?> </li>
            <li><?php echo $this->Html->link(__(' Sửa giao dịch'), '/chinh-sua-giao-dich/'.$transaction['Transaction']['slug']); ?> </li>
			<li><?php echo $this->Form->postLink(__(' Xóa giao dịch'), array('action' => 'delete', $transaction['Transaction']['id']), array('confirm' => __(' Bạn có chắc chắn muốn xóa %s?', $transaction['Transaction']['id']))); ?> </li>
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
		<div class="transactions view">
			<div class="panel panel-primary">
				<div class="panel-heading">
	      			<h3 class="panel-title"><?php echo __('Chi tiết giao dịch'); ?></h3>
	    		</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td rowspan="6" style="width:200px"><?php echo $this->Html->image('/img/transactions.png', array('width'=>200, 'height' => 200, 'class' => ' img-circle ')); ?></td>
								<th style="width:200px"><?php echo __(' Giá trị'); ?></th>
								<th><?php echo $this->Number->format($transaction['Transaction']['amount'],array(
									'places' => 0,
									'before' => null,
								    'escape' => false,
								    'decimals' => '.',
								    'thousands' => ','
								    )); ?>
								    <?php echo $transaction['Wallet']['currency']; ?>
								    </th>
							</tr>
							<tr>
								<th><?php echo __(' Ngày tạo giao dịch:'); ?></th>
								<th><?php echo date('d-m-Y', strtotime($transaction['Transaction']['create_date'])); ?></th>
							</tr>
							<tr>
								<th><?php echo __(' Ghi chú:'); ?></th>
								<th><?php echo h($transaction['Transaction']['note']); ?></th>
							</tr>
							<tr>
								<th><?php echo __(' Ví sử dụng:'); ?></th>
								<th><?php echo $this->Html->link($transaction['Wallet']['wallet_name'], '/thong-tin-vi/'.$transaction['Wallet']['slug']); ?></th>
							</tr>
							<tr>
								<th><?php echo __(' Danh mục:'); ?></th>
								<th><?php echo $this->Html->link($transaction['Category']['category_name'], '/chi-tiet-danh-muc/'.$transaction['Category']['id']); ?></th>
							</tr>
							<tr>
								<th><?php echo __(' Kiểu danh mục:'); ?></th>
								<th><?php echo $this->Html->link($transaction['Category']['category_type'], '/chi-tiet-danh-muc/'.$transaction['Category']['id']); ?></th>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>


</html>