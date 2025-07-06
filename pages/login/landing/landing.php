<div class="vh-100 d-flex flex-row bg-body-primary">
    <div class="d-none d-md-flex align-items-center justify-content-center">
        <div class="h-75 d-flex justify-content-center align-items-center w-100">
            <img class="img-fluid" src="<?php echo image('login-blue.svg'); ?>" alt="">
        </div>
    </div>
    <div class="w-md-41 d-flex align-items-center justify-content-center bg-body-primary p-2">
        <div class="card w-md-90">
            <div class="mx-auto mt-5 p-2">
                <img class="img-fluid" src="<?php echo image('logo.svg'); ?>" alt="">
            </div>
            <div class="card-body">
                <div class="d-flex flex-column">
                    <div class="mb-2">
                        <label for="user" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="user" autocomplete="username"/>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" autocomplete="current-password"/>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="ms-3 hover">
                            <a class="link" href="login.php?tab=dont_remember_password">Non ricordo la Password</a>
                        </div>
                    </div>
                    <div class="my-4">
                        <button class="btn btn-primary w-100" onclick="login()">Avanti</button>
                    </div>
                </div>
                <form style="display:none">
                    <input type="text" name="username" autocomplete="username"/>
                    <input type="password" name="password" autocomplete="current-password"/>
                    <input type="submit"/>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="success" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="1500" data-bs-animation="true">
        <div class="toast-header p-0 m-0">
            <div class="d-flex justify-content-start align-content-center" style="height:40px!important">
                <div class="p-2"><?php echo icon('square.svg','green',20,20);?></div>
                <div class="p-2"><h4 class="">Riuscito</h4></div>
            </div>
        </div>
        <div class="toast-body">Ben venuto a medplus</div>
    </div>
    <div id="wrong_pass" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" data-bs-animation="true">
        <div class="toast-header p-0 m-0">
            <div class="d-flex justify-content-start align-content-center flex-fill" style="height:40px!important">
                <div class="p-2"><?php echo icon('square.svg','red',20,20);?></div>
                <div class="p-2"><h4 class="">Password non corrisponde</h4></div>
                <div class="ms-auto align-content-center"><button type="button" class="btn-close me-1 p-2" data-bs-dismiss="toast" aria-label="Close"></button></div>
            </div>
            
        </div>
        <div class="toast-body">Verifica la password e riprova</div>
    </div>
    <div id="wrong_user" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" data-bs-animation="true">
        <div class="toast-header p-0 m-0">
            <div class="d-flex justify-content-start align-content-center flex-fill" style="height:40px!important">
                <div class="p-2"><?php echo icon('square.svg','red',20,20);?></div>
                <div class="p-2"><h4 class="">Username non trovato</h4></div>
                <div class="ms-auto align-content-center"><button type="button" class="btn-close me-1 p-2" data-bs-dismiss="toast" aria-label="Close"></button></div>
            </div>
            
        </div>
        <div class="toast-body">Verifica username e riprova</div>
    </div>
</div>
<?php script('pages/login/landing/landing.js'); ?>