<?php 
$_REQUEST['skip_cookie'] = true;
require_once  __DIR__.'/../includes.php';
require_once __DIR__.'/../includes/header.php';
$new_password=password_hash($_REQUEST['password'],PASSWORD_DEFAULT);
Update('utenti')->set(['password'=>$new_password])->where("id={$_REQUEST['id']}");
?>
    <div class="container vh-100">
        <div class="d-flex flex-column align-content-center justify-content-center vh-100 w-100">
            <div class="card w-80 mx-auto">
                <div class="mx-auto mt-5 p-2">
                    <a href="login.php?tab=landing">
                        <img class="img-fluid" src="<?php echo image('logo.svg'); ?>" alt="">
                    </a>
                </div>  
                <div class="card-body text-center p-5">
                    <div>
                        <h3>Password Cambiata con successo</h3>
                    </div>
                    <div class="mt-3">
                        <a href="../login.php?tab=landing">Torna a Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require_once __DIR__.'/../includes/footer.php';