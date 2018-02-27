<b><?php
	echo $this->Paginator->counter('Trang {:page}/{:pages}, hiển thị {:current} '.$object.' trong tổng số {:count} '.$object);
	?></b></br>
<ul class="pagination">
    <?php echo $this->Paginator->prev(__('Trở lại'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>
    <?php echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li')); ?>
    <?php echo $this->Paginator->next(__('Kế tiếp'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a')); ?>
</ul>