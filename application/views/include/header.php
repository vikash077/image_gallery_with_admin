<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="<?php echo base_url('index.php/admin'); ?>" class="navbar-brand"><b>Somany Ceramics </b>Admin</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="<?php echo base_url('index.php/admin'); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user_data['name']; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url('index.php/admin'); ?>">Documents</a></li>
                            <li><a href="<?php echo base_url('index.php/users/'); ?>">Users</a></li>
                            <li><a href="<?php echo base_url('/'); ?>" target="_blank">Visit Site</a></li>
                            <li><a href="<?php echo base_url('index.php/login/logout'); ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>