<?php
/**
 * file:userInfo.php
 * author:Toruneko@outlook.com
 * date:2014-7-14
 * desc:个人信息
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">您好，<?php echo $this->user->nickname; ?> ( <?php echo $this->user->realname; ?> )</div>
    <div class="panel-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <p>登录名：<?php echo $this->user->username; ?></p>

                    <p>
                        最近登录时间：<?php echo $this->user->last_login_time ? date('Y-m-d H:i:s', $this->user->last_login_time) : ''; ?></p>

                    <p>最近登录IP：<?php echo $this->user->last_login_ip ? $this->user->last_login_ip : ''; ?></p>

                    <p>注册时间：<?php echo date('Y-m-d H:i:s', $this->user->sign_up_time); ?></p>

                    <p>注册IP：<?php echo $this->user->sign_up_ip; ?></p>

                    <p>角色：<?php echo join(',', $this->user->role); ?></p>

                    <p>用户组：<?php echo join(',', $this->user->group); ?></p>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4"></div>
            </div>
        </div>
    </div>
</div>