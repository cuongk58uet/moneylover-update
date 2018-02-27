<!DOCTYPE html>
<head>
	
</head>
<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          	<li class="active"><?php echo $this->Html->link(__('Trang chủ'), ''); ?></li>
          <?php if(!empty($wallets)): ?>
            <li><?php echo $this->Html->link(__(' Thêm giao dịch mới'), array('action' => 'add')); ?></li>
          <?php endif ?>
            <li><?php echo $this->Html->link(__('Thêm ví mới'), array('controller' => 'wallets', 'action' => 'add')); ?> </li>
            <li><?php echo $this->Html->link(__('Thêm danh mục mới'), array('controller' => 'categories', 'action' => 'add')); ?></li>
            <li><?php echo $this->Html->link(__('Danh sách ví'), array('controller' => 'wallets', 'action' => 'index')); ?></li>
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
		<div class="transactions index">
			<?php if(empty($wallets)): ?>
				<h3>Xin chào <b><?php echo $user_info['User']['fullname'];?></b></h3>
				<h4><strong> Có vẻ bạn chưa tạo ví nào. Nhấn vào <?php echo $this->Html->link('đây', array('controller'=> 'wallets', 'action' => 'add')) ; ?> để tạo ví mới </strong></h4></br>
			<?php else: ?>
			<?php if(!empty($transactions)): ?>
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
							</td>
						</tr>
					</table>
					<?php echo $this->Html->link(__('Chi tiết'), '/bao-cao-hang-thang/'.$currentMonth.'/'.$currentYear , array('class' => 'btn btn-primary')); ?>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
	          			<h3 class="panel-title"><span class="glyphicon glyphicon-search"></span> <?php echo __('Tìm kiếm nhanh'); ?></h3>
	        		</div>
					<div class="panel-body">
					
					<?php echo $this->Form->create('Transaction', array('type' => 'get')); ?>
					<div class="table-responsive">
					<table>
					<tr>
						<th>Ngày giao dịch: </th>
						<td>
							<?php echo $this->Form->day('create_date', array(
								'class' => 'form-control',
								'empty' => 'Ngày'
							)); ?>
						</td>
						<td style="padding:2px">
							<?php echo $this->Form->month('create_date', array(
								'class' => 'form-control',
								'monthNames' => array('01' => 'Tháng 1', '02'=> 'Tháng 2', '03'=> 'Tháng 3', '04'=> 'Tháng 4', '05'=> 'Tháng 5', '06'=> 'Tháng 6', '07'=> 'Tháng 7', '08'=> 'Tháng 8', '09'=> 'Tháng 9', '10'=> 'Tháng 10', '11'=> 'Tháng 11', '12' => 'Tháng 12'),
								'empty' => 'Tháng'
							)); ?>
						</td>
						<td>
							<?php echo $this->Form->year('create_date', date('Y')-5, date('Y')+5, array(
							'class' => 'form-control',
							'empty' => 'Năm'
							)); ?>
						</td>
						<td style="padding:5px"><?php echo $this->Form->input('wallet_id', array(
							'class' =>'form-control',
							'label' => false,
							'empty' =>'Tất cả các ví'
						)); ?></td>
						<td style="padding:5px"> <?php echo $this->Form->button('Tìm kiếm',array('type' => 'submit','class'=>'btn btn-primary ')); ?></td>
						<td><?php echo $this->Html->link('Tất cả giao dịch', '/trang-chu', array('class' => 'btn btn-default')); ?></td>
					</tr>
					
					</table>
					</div>
					<?php echo $this->Form->end(); ?>

					</div>
				</div>
				<?php if(!$allowDisplayList): ?>
				<?php if(!empty($search_result)): ?>
					<h2 ><b><?php echo 'Các giao dịch trong ngày '.date('d/m/Y',strtotime($search_result['0']['Transaction']['create_date'])); ?></b></h2>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
										<th><?php echo $this->Paginator->sort('create_date','Ngày giao dịch'); ?></th>
										<th><?php echo $this->Paginator->sort('amount','Giá trị'); ?></th>
										<th><?php echo $this->Paginator->sort('note','Ghi chú'); ?></th>
										<th><?php echo $this->Paginator->sort('wallet_name', 'Tên ví'); ?></th>
										<th><?php echo $this->Paginator->sort('Category.category_type','Danh mục'); ?></th>
										<th style="color:#337ab7"><?php echo __('Tùy chọn'); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($search_result as $result): ?>
								<tr>
									<td><?php echo date('d-m-Y',strtotime($result['Transaction']['create_date'])); ?>&nbsp;</td>
									<td><?php echo $this->Number->format($result['Transaction']['amount'],array(
											'places' => 0,
											'before' => null,
										    'escape' => false,
										    'decimals' => '.',
										    'thousands' => ','
										    )); ?>&nbsp;
										    <b><?php echo $result['Wallet']['currency']; ?></b>
									</td>
									<td><?php echo h($result['Transaction']['note']); ?>&nbsp;</td>
									<td>
										<?php echo $this->Html->link($result['Wallet']['wallet_name'], '/thong-tin-vi/'.$result['Wallet']['slug']); ?>
									</td>
									<td>
										<?php echo $this->Html->link($result['Category']['category_type'], '/chi-tiet-danh-muc/'.$result['Category']['id']); ?>
									</td> 
									<td class="actions">
										<?php echo $this->Html->link(__('Chi tiết'), '/chi-tiet-giao-dich/'.$result['Transaction']['slug'],array('class' => 'btn btn-sm btn-info')); ?>
										<?php echo $this->Html->link(__('Sửa'), '/chinh-sua-giao-dich/'.$result['Transaction']['slug'],array('class' => 'btn btn-sm btn-success')); ?>
										<?php echo $this->Form->postLink(__('Xóa'), array('action' => 'delete', $result['Transaction']['id']), array('confirm' => __('Bạn có chắc chắn muốn xóa %s?', $result['Transaction']['note']), 'class'=>'btn btn-sm btn-danger')); ?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php else: ?>
					<h3>Không tìm thấy giao dịch nào</h3>
				<?php endif ?>
				<?php endif ?>
				<?php if($allowDisplayList): ?>
					<h2><b><?php echo __('Tất cả giao dịch'); ?></b></h2>
					<div class="table-responsive">
						<table class="table table-striped">
						<thead>
						<tr>
								<th><?php echo $this->Paginator->sort('create_date','Ngày giao dịch'); ?></th>
								<th><?php echo $this->Paginator->sort('amount','Giá trị'); ?></th>
								<th><?php echo $this->Paginator->sort('note','Ghi chú'); ?></th>
								<th><?php echo $this->Paginator->sort('Category.category_type','Danh mục'); ?></th>
								<th style="color:#337ab7"><?php echo __('Tùy chọn'); ?></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($transactions as $transaction): ?>
						<tr>
							<td><?php echo date('d-m-Y',strtotime($transaction['Transaction']['create_date'])); ?>&nbsp;</td>
							<td><b><?php echo $this->Number->format($transaction['Transaction']['amount'],array(
									'places' => 0,
									'before' => null,
								    'escape' => false,
								    'decimals' => '.',
								    'thousands' => ','
								    )); ?></b>
								    <?php echo $transaction['Wallet']['currency']; ?>
							</td>
							<td><?php echo h($transaction['Transaction']['note']); ?>&nbsp;</td>
							<td>
								<?php echo $this->Html->link($transaction['Category']['category_type'], '/chi-tiet-danh-muc/'.$transaction['Category']['id']); ?>
							</td> 
							<td class="actions">
								<?php echo $this->Html->link(__('Chi tiết'), '/chi-tiet-giao-dich/'.$transaction['Transaction']['slug'],array('class' => 'btn btn-sm btn-info')); ?>
								<?php echo $this->Html->link(__('Sửa'), '/chinh-sua-giao-dich/'.$transaction['Transaction']['slug'],array('class' => 'btn btn-sm btn-success')); ?>
								<?php echo $this->Form->postLink(__('Xóa'), array('action' => 'delete', $transaction['Transaction']['id']), array('confirm' => __('Bạn có chắc chắn muốn xóa %s?', $transaction['Transaction']['note']), 'class'=>'btn btn-sm btn-danger')); ?>
							</td>
						</tr>
						<?php endforeach; ?>
						</tbody>
						</table>
					</div>
				<?php endif ?>
					<?php echo $this->Html->link(__(' Thêm giao dịch mới'), array('controller' => 'transactions', 'action' => 'add'), array('class' => 'btn btn-sm btn-primary')); ?></br>
					<?php echo $this->element('paginate', array('object' => 'giao dịch')); ?>
				</div>
	<?php else: ?>
		<h1>Oh!!!</h1>
		<h4><strong> Bạn chưa tạo giao dịch nào. Nhấn vào <?php echo $this->Html->link('đây', array('controller'=> 'transactions', 'action' => 'add')) ; ?> để tạo giao dịch mới </strong></h4>
	<?php endif ?>
	<?php endif ?>
	</div>
</body>
</html>