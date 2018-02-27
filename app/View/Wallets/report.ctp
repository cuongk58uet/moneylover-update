<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header'); ?>
	<br>
	<button type="button" class="btn btn-default" data-toggle="collapse" data-target=".sidebar"><i class="glyphicon glyphicon-chevron-right"></i> Menu</button>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
      		<li class="active"><?php echo $this->Html->link(__('Chi tiết báo cáo'), ''); ?> </li>
			<li><?php echo $this->Html->link(__('Trở về'), '/thong-tin-vi/'.$wallet['Wallet']['slug']); ?> </li>
          </ul>
	</div>

	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<?php echo $this->Session->flash(); ?>
		<div class="wallets index">
			<div class="jumbotron">
			<h3><b><?php echo $wallet['Wallet']['wallet_name']; ?></b></h3>
			<h3>Tổng quan tháng <?php echo $month.' - '.$year ?></h3>
			<table class="table" style="width:auto; border:none;">
				<tr>
					<td><b>Tiền vào:</b></td>
					<td>
					<?php if(!empty($inflow['0']['0']['Total'])): ?>
						<?php echo $this->Number->format($inflow['0']['0']['Total'],array(
							'places' => 0,
							'before' => null,
						    'escape' => false,
						    'decimals' => '.',
						    'thousands' => ','
						    )) ?>
						    <b><?php echo $wallet['Wallet']['currency']; ?></b>
					<?php else: ?>
						<b style="color: #0080ff">Không có dữ liệu để hiển thị</b>
					<?php endif ?>
					</td>
					

				</tr>
				<tr>
					<td><b>Tiền ra:</b></td>
					<td>
					<?php if(!empty($outflow['0']['0']['Total'])): ?>
					<?php echo $this->Number->format($outflow['0']['0']['Total'], array(
						'places' => 0,
						'before' => null,
					    'escape' => false,
					    'decimals' => '.',
					    'thousands' => ','
					    )) ?>
					    <b><?php echo $wallet['Wallet']['currency']; ?></b>
					<?php else: ?>
						<b style="color: #0080ff">Không có dữ liệu để hiển thị</b>
					<?php endif ?>
					</td>
				</tr>
				<tr>
					<td><b>Thu nhập ròng:</b></td>
					<td>
					<?php if(!empty($netIncome)): ?>
					<?php echo $this->Number->format($netIncome, array(
						'places' => 0,
						'before' => null,
					    'escape' => false,
					    'decimals' => '.',
					    'thousands' => ','
					    )) ?>
					    <b><?php echo $wallet['Wallet']['currency']; ?></b>
					<?php else: ?>
						<b style="color: #0080ff">Không có dữ liệu để hiển thị</b>
					<?php endif ?>
					</td>
				</tr>
			</table>
			<?php if($netIncome < 0): ?>
				<h4><b style=" color: red">Bạn đã chi tiêu quá tay trong tháng này. Hãy nhanh chóng điều chỉnh kế hoạch chi tiêu hợp lý</b></h4></br>
			<?php endif ?>
			<h4><b>Khoản chi lớn nhất: </b> 
			<?php if(!empty($most_outflow['Transaction']['amount'])): ?>
			<?php echo $this->Number->format($most_outflow['Transaction']['amount'], array(
						'places' => 0,
						'before' => null,
					    'escape' => false,
					    'decimals' => '.',
					    'thousands' => ','
					    )) ?>
			<?php else: ?>
						
			<?php endif ?>
						</h4>
		    <h5><b>Danh mục:</b> 
		    <?php if(!empty($most_outflow['Category']['category_name'])): ?>
		    	<?php echo $most_outflow['Category']['category_name']?>
		    <?php else: ?>
		    	<b style="color: #0080ff"></b>
		    <?php endif ?>
		    </h5>

			<h5><b>Ghi chú:</b> 
			<?php if(!empty($most_outflow['Transaction']['note'])): ?>
				<?php echo $most_outflow['Transaction']['note']?>
			<?php else: ?>
				<b style="color: #0080ff"></b>
			<?php endif ?>
			</h5>
			<h5><b>Ngày tạo giao dịch:</b> 
			<?php if(!empty($most_outflow['Transaction']['create_date'])): ?>
				<?php echo date('d-m-Y',strtotime($most_outflow['Transaction']['create_date']))?>
			<?php else: ?>
				<b style="color: #0080ff"></b>
			<?php endif ?>
			</h5></br>
			<!--  -->
			<h4><b>Chi tiêu theo nhóm:</b></h4>
			<?php if(!empty($details_outflow)): ?>
				<table class="table" style="width:auto">
				<?php foreach ($details_outflow as $detail): ?>
					<tr>
						<th><?php echo $detail['Category']['category_name']?>:</th>
						<td><?php echo $this->Number->format($detail['0']['Total'], array(
						'places' => 0,
						'before' => null,
					    'escape' => false,
					    'decimals' => '.',
					    'thousands' => ','
					    )).' '.$detail['Wallet']['currency']; ?></td>
					    <td><?php echo $this->Number->toPercentage($detail['0']['Total']/$outflow['0']['0']['Total']*100); ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php else: ?>
				<b style="color: #0080ff">Không có khoản chi tiêu nào</b>
			<?php endif ?>
			
			<!--  -->
			</br><h4><b>Thu nhập:</b></h4>
			<?php if(!empty($details_inflow)): ?>
				<?php foreach ($details_inflow as $details_inflow): ?>
					<h5><b><?php echo $details_inflow['Category']['category_name']?>: </b><?php echo $this->Number->format($details_inflow['0']['Total'], array(
						'places' => 0,
						'before' => null,
					    'escape' => false,
					    'decimals' => '.',
					    'thousands' => ','
					    ))?> </h5>
				<?php endforeach; ?>
			<?php else: ?>
				<b style="color: #0080ff">Không có khoản thu nhập nào</b>
			<?php endif ?>

			</br></br><h4><b>Xem tổng quan của tháng khác: </b></h4>
			<div class="categories form">
				<?php echo $this->Form->create('Wallet'); ?>
				<fieldset>
					<table>
						<tr>
							<th>Chọn thời gian: </th>
							<td style="padding:2px">
								<?php echo $this->Form->month('date', array(
									'class' => 'form-control',
									'monthNames' => array('01' => 'Tháng 1', '02'=> 'Tháng 2', '03'=> 'Tháng 3', '04'=> 'Tháng 4', '05'=> 'Tháng 5', '06'=> 'Tháng 6', '07'=> 'Tháng 7', '08'=> 'Tháng 8', '09'=> 'Tháng 9', '10'=> 'Tháng 10', '11'=> 'Tháng 11', '12' => 'Tháng 12'),
									'empty' => false,
									'default' => date('m')
								)); ?>
							</td>
							<td>
								<?php echo $this->Form->year('date', date('Y')-5, date('Y')+5, array(
								'class' => 'form-control',
								'empty' => false,
								'default' => date('Y')
								)); ?>
							</td>
						</tr>
					</table>
				</fieldset>
				</br>
				<?php echo $this->Form->button('Xem',array('type' => 'submit','class'=>'btn btn-primary')); ?>
				<?php echo $this->Form->end(); ?>
			</div>
			</div>
		</div>
	</div>
</body>


</html>