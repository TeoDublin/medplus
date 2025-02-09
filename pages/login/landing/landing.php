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
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control"/>
                    </div>
                    <div class="my-4">
                        <button class="btn btn-primary w-100" >Avanti</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php script('pages/login/landing/landing.js'); ?>