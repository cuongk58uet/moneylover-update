<html>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="nav navbar-brand" href='<?php echo $this->webroot."trang-chu";?>'><i class="glyphicon glyphicon-home"></i><b> Money Lover</b></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href='<?php echo $this->webroot."trang-chu";?>'>Trang chủ</a></li>
            <li><a href='<?php echo $this->webroot."lien-he";?>'>Liên hệ</a></li>
            <li><a href='<?php echo $this->webroot."ve-chung-toi";?>'> Về chúng tôi</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown"><b><?php echo $this->Html->image($user_info['User']['avatar'], array('class' => 'img-circle', 'width' => 30, 'height' =>30)); echo $user_info['User']['username'];?></b><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href='<?php echo $this->webroot."thong-tin-ca-nhan";?>'><i class="glyphicon glyphicon-user"></i> Thông tin cá nhân</a></li>
                <li><a href='<?php echo $this->webroot."doi-mat-khau";?>'><i class="glyphicon glyphicon-edit"></i> Đổi mật khẩu</a></li>
                <li><a href='<?php echo $this->webroot."users/logout";?>'><i class="glyphicon glyphicon-log-out"></i>  Đăng xuất</a></li>
              </ul>
            </li>
          </ul>
        </div>
    </div>
</div>
</html>