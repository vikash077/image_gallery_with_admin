<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Somany Ceramics | Gallery</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.min.css'); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('/assets/dist/css/AdminLTE.min.css'); ?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url('/assets/dist/css/skins/_all-skins.min.css'); ?>">

        <link rel="stylesheet" href="<?php echo base_url('/assets/dist/css/jquery.tagsinput.min.css'); ?>">
        <!-- jQuery 2.2.3 -->
        <script src="<?php echo base_url('/assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>


        <script>
            var BASE_URL = '<?php echo base_url(); ?>';
        </script>
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    <body class="hold-transition skin-blue layout-top-nav">
        <div class="wrapper">
            <?php echo $header; ?>
            <!-- Full Width Column -->
            <div class="content-wrapper">
                <div class="container">

                    <!-- Main content -->
                    <section class="content" id="main_container">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userRegisterModal">
                                    <i class="fa fa-plus" aria-hidden="true" style="color:#f25635"></i> Add User
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <?php $success =  $this->session->flashdata('success'); 
                               if(!empty($success)){
                               ?>
                                <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-info"></i> Success!</h4>
                                        <?php echo $success; ?>
                                    </div>
                                
                               <?php } ?>
                                
                                <?php $error =  $this->session->flashdata('error'); 
                               if(!empty($error)){
                               ?>
                                <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-warning"></i> Error!</h4>
                                        <?php echo $error; ?>
                                    </div>
                                
                               <?php } ?>
                                
                                <?php $errors =  $this->session->flashdata('errors'); 
                               if(!empty($errors)){
                               ?>
                                <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-warning"></i> Error!</h4>
                                        <?php $errors = json_decode($errors);
                                        foreach($errors as $error){
                                            echo '<p>'.$error.'</p>';
                                        }
                                        ?>
                                    </div>
                                
                               <?php } ?>
                                
                                <?php if (!empty($data)) { ?>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>USER_NAME</th>
                                        <th>ROLE</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                    foreach ($data as $d) { ?> 
                                    <tr>
                                        <td><?php echo $d->id; ?></td>
                                        <td><?php echo $d->Name; ?></td>
                                        <td><?php echo $d->user_name; ?></td>
                                        <td><?php echo $d->access; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary edit_user">Edit</button>
                                            <button type="button" data-id="<?php echo $d->id; ?>" class="btn btn-danger delete_user">Delete</button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                    <?php } else {
                                    ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-info"></i> No Data Found!</h4>
                                        Add a new user, No user added yet! <br/>Press the + button, below the list of accounts on the left, to add a new user account.
                                    </div>
                                    <?php }
                                ?>
                            </div>
                        </div>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.container -->
            </div>
            <?php echo $footer; ?>
        </div>
        <!-- ./wrapper -->


        <!-- Modal -->
        <div style="z-index: 99999;" class="modal fade" id="userRegisterModal" tabindex="-1" role="dialog" aria-labelledby="userRegisterModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div id="loadingbar" class="bar loadingbar" style="display:none;"></div>
                        <h5 class="modal-title" id="userRegisterModalLabel">Details:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="register-user" method="post" action="<?php echo base_url('index.php/admin/createPasswordUser'); ?>">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required="required">
                            </div>  
                            <div class="form-group">
                                <label for="email" class="col-form-label">email:</label>
                                <input type="email" class="form-control" id="email" name="email" required="required">
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="text" class="form-control" id="password"  name="password" required="required">
                            </div>
                            <div class="form-group">
                                <label for="cpassword" class="col-form-label">Confirm Password:</label>
                                <input type="text" class="form-control" id="cpassword"  name="cpassword" required="required">
                            </div>
                            <div class="form-group">
                                <label for="access" class="col-form-label">Access:</label>
                                <select class="form-control" id="access"  name="access" required="required">
                                    <option>User</option>
                                    <option>Admin</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="register-user">Continue</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo base_url('/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        <script>
            $(function(){
                $('.delete_user').click(function(){
                    id = $(this).data('id');
                    bootbox.confirm('Do you want to continue?',function(result){
                        if(result === true){
                            window.location = '<?php echo base_url('index.php/admin/delete_user');?>/'+id;
                        }
                    });
                });
            });
        </script>
    </body>
</html>