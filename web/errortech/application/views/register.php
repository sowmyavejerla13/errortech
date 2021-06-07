<?php $this->load->view('scripts'); ?>

    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                        </div>
                        <h5 class="font-18 text-center">Sign Up</h5>
    
                        <form class="form-horizontal m-t-30" method="post" action="<?php echo site_url('register/register')?>">

                            <div class="form-group">
                                <div class="col-12">
                                        <label>Full Name</label>
                                    <input class="form-control" name="full_name" type="text" required="" placeholder="Full Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Email</label>
                                    <input class="form-control" name="email" type="email" required="" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Password</label>
                                    <input class="form-control" name="password" type="password" required="" placeholder="Password">
                                </div>
                            </div>
                           
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button name="register" class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Create Account</button>
                                </div>
                            </div>
    
                            <div class="form-group mb-0 row">
                                    <div class="col-12 m-t-10 text-center">
                                        <a href="<?php echo site_url('login')?>" class="text-muted">Have An Account? SIgnIn</a>
                                    </div>
                                </div>
                        </form>
                    </div>
     <!-- Display status message -->
     <?php if(!empty($success_msg)){ ?>
    <div class="col-xs-12">
        <div class="alert alert-success"><?php echo $success_msg; ?></div>
    </div>
    <?php } if(!empty($error_msg)){ ?>
    <div class="col-xs-12">
        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
    </div>
    <?php } ?>
                </div>
            </div>
        
       
        
    </body>

</html>