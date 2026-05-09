<?php 
    
?>

<div class="container vh-100">
    <div class="d-flex flex-column align-content-center justify-content-center vh-100 w-100">
        <div class="card w-50 mx-auto">
            <div class="mx-auto mt-5 p-2">
                <a href="login.php?tab=landing">
                    <img class="img-fluid" src="<?php echo image('logo.svg'); ?>" alt="">
                </a>
            </div>            
            <div class="card-body">
                <div class="form-control mb-2">
                    <div class="mb-3">
                        <label for="user" class="form-label">Utente</label>
                        <input
                            type="text"
                            class="form-control"
                            name="user"
                            id="user"
                        />
                    </div>
                </div>
                <div class="mb-3">
                    <a href="login.php?tab=landing">Torna a login</a>
                </div>
                <small id="helpId" class="form-text text-muted fst-italic">Un'email sarà inviato il link per cambiare password</small>
                <div class="w-100 mt-3" onclick="send_current()">
                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Invia
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php script('pages/login/dont_remember_password/dont_remember_password.js'); ?>
</div>