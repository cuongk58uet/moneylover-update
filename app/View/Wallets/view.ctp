<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          	<li class="active"><?php echo $this->Html->link(__(' Chi tiết ví'), ''); ?> </li>
            <li><?php echo $this->Html->link(__(' Chỉnh sửa ví'), '/chinh-sua-vi/'.$wallet['Wallet']['slug']); ?> </li>
			<li><?php echo $this->Form->postLink(__(' Xóa ví'), array('action' => 'delete', $wallet['Wallet']['id']), array('confirm' => __('Bạn có chắc chắn muốn xóa %s?', $wallet['Wallet']['wallet_name']))); ?> </li>
			<li><?php echo $this->Html->link(__(' Trở lại'), array('action' => 'index')); ?> </li>
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
		<div class="wallets view">
			<div class="panel panel-primary">
				<div class="panel-heading">
          			<h3 class="panel-title"><?php echo __(' Thông tin ví'); ?></h3>
        		</div>
				<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th rowspan="4" style="width:200px"><?php echo $this->Html->image('/img/wallets.png',array('width'=>200, 'height' => 200, 'class' => ' img-circle ')); ?></th>
							<th style="width:120px"><?php echo __(' Tên ví:'); ?></th>
							<th><?php echo h($wallet['Wallet']['wallet_name']); ?></th>
						</tr>
						<tr>
							<th><?php echo __(' Đơn vị tiền tệ:'); ?></th>
							<td><?php echo h($wallet['Wallet']['currency']); ?></td>
						</tr>
						<tr>
							<th><?php echo __(' Số dư:'); ?></th>
							<th><?php echo $this->Number->format($wallet['Wallet']['banlances'], array(
								'places' => 0,
								'before' => null,
							    'escape' => false,
							    'decimals' => '.',
							    'thousands' => ','
							    )); echo ' '.$wallet['Wallet']['currency']; ?></th>
						</tr>
						<tr>
							<th><?php echo __('Tài khoản:'); ?></th>
							<td><?php echo $this->Html->link($wallet['User']['username'], '/thong-tin-ca-nhan/'); ?></td>
						</tr>
					</table>
				</div>
					<h2><?php echo __('Ví cá nhân'); ?></h2>
				</div>
			</div>
		</div>
		<div class="jumbotron">
			<h3><b>Tổng quan tháng <?php echo date('m - Y'); ?></b></h3>
			<table class="table" style="width:auto;">
				<tr>
					<td><b>Tiền vào:</b></td>
					<td>
						<?php echo $this->Number->format($inflow['0']['0']['Total'],array(
							'places' => 0,
							'before' => null,
						    'escape' => false,
						    'decimals' => '.',
						    'thousands' => ','
						    )) ?>
						    <b><?php echo $wallet['Wallet']['currency']; ?></b>
					</td>
				</tr>
				<tr>
					<td><b>Tiền ra:</b></td>
					<td>
						<?php echo $this->Number->format($outflow['0']['0']['Total'], array(
							'places' => 0,
							'before' => null,
						    'escape' => false,
						    'decimals' => '.',
						    'thousands' => ','
						    )) ?>
						    <b><?php echo $wallet['Wallet']['currency']; ?></b>
					</td>
				</tr>
				<tr>
					<td><b>Thu nhập ròng:</b></td>
					<td>
						<?php echo $this->Number->format($netIncome, array(
							'places' => 0,
							'before' => null,
						    'escape' => false,
						    'decimals' => '.',
						    'thousands' => ','
						    )) ?>
						    <b><?php echo $wallet['Wallet']['currency']; ?></b>
					</td>
				</tr>
			</table>
			<?php echo $this->Html->link(__('Chi tiết'), '/bao-cao-hang-thang/'.$wallet['Wallet']['slug'].'/'.$currentMonth.'/'.$currentYear , array('class' => 'btn  btn-primary')); ?>
		</div>
		<div class="related">
			<h2><?php echo __('Giao dịch liên quan'); ?></h2>
			<?php if (!empty($transactions)): ?>
				<div class="table-responsive">
				<table class="table table-striped">
				<thead>
					<tr>
							<th><?php echo $this->Paginator->sort('Transaction.create_date','Ngày giao dịch'); ?></th>
							<th><?php echo $this->Paginator->sort('Transaction.amount','Giá trị'); ?></th>
							<th><?php echo $this->Paginator->sort('Transaction.note','Ghi chú'); ?></th>
							<th><?php echo $this->Paginator->sort('Category.category_type','Danh mục'); ?></th>
							<th style="color:#337ab7"><?php echo __('Tùy chọn'); ?></th>
					</tr>
				</thead>
				<?php foreach ($transactions as $transaction): ?>
					<tr>
						<td><?php echo date('d-m-Y',strtotime($transaction['Transaction']['create_date'])); ?></td>
						<td><?php echo $this->Number->format($transaction['Transaction']['amount'],array(
						'places' => 0,
						'before' => null,
					    'escape' => false,
					    'decimals' => '.',
					    'thousands' => ','
					    )); ?></td>
						<td><?php echo $transaction['Transaction']['note']; ?></td>
						<td><?php echo $transaction['Category']['category_type']; ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('Chi tiết'), '/chi-tiet-giao-dich/'.$transaction['Transaction']['slug'], array('class' => 'btn btn-sm btn-info')); ?>
							<?php echo $this->Html->link(__('Sửa'), '/chinh-sua-giao-dich/'.$transaction['Transaction']['slug'], array('class' => 'btn btn-sm btn-success')); ?>
							<?php echo $this->Form->postLink(__('Xóa'), array('controller' => 'transactions', 'action' => 'delete', $transaction['Transaction']['id']), array('confirm' => __(' Bạn có chắc chắn muốn xóa %s?', $transaction['Transaction']['note']), 'class' => 'btn btn-sm btn-danger')); ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</table>
				<?php echo $this->element('paginate', array('object' => 'giao dịch')); ?>
				</div>
			<?php else: ?>
				<h4><strong> Ví này không có giao dịch nào. Nhấn vào <?php echo $this->Html->link('đây', array('controller'=> 'transactions', 'action' => 'add')) ; ?> để tạo giao dịch mới </strong></h4>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>