<?php 
$_REQUEST['skip_cookie'] = true;
require_once 'includes.php';
require_once 'includes/header.php';
$user=Select('*')->from('utenti')->where("id='{$_REQUEST['id']}'")->first_or_false();
if(!$user){?>
    <div class="container vh-100">
        <div class="d-flex flex-column align-content-center justify-content-center vh-100 w-100">
            <div class="card w-50 mx-auto">         
                <div class="card-body text-center">
                    <h1>Utente non trovato</h1>
                </div>
            </div>
        </div>
    </div>
    <?php
}
elseif($user['expiry']<now('Y-m-d H:i:s')){?>
    <div class="container vh-100">
        <div class="d-flex flex-column align-content-center justify-content-center vh-100 w-100">
            <div class="card w-50 mx-auto">
                <div class="mx-auto mt-5 p-2">
                    <a href="login.php?tab=landing">
                        <img class="img-fluid" src="<?php echo image('logo.svg'); ?>" alt="">
                    </a>
                </div>            
                <div class="card-body text-center">
                    <h1>Token scaduto</h1>
                </div>
            </div>
        </div>
    </div>
    <?php
}
else{?>
    <div class="container vh-100">
        <div class="d-flex flex-column align-content-center justify-content-center vh-100 w-100">
            <div class="card w-50 mx-auto">
                <div class="mx-auto mt-5 p-2">
                    <a href="login.php?tab=landing">
                        <img class="img-fluid" src="<?php echo image('logo.svg'); ?>" alt="">
                    </a>
                </div>            
                <div class="card-body">
                    <form method="POST" action="post/change_password.php">
                        <input name="id" id="id" value="<?php echo $user['id']; ?>" hidden/>
                        <div class="mb-3">
                            <label for="utente" class="form-label">Utente</label>
                            <input
                                type="text"
                                class="form-control"
                                name="utente"
                                id="utente"
                                value="<?php echo $user['user']; ?>"
                                disabled
                            />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nuova Password</label>
                            <input
                                type="text"
                                class="form-control"
                                name="password"
                                id="password"
                            />
                        </div>
                        <div class="w-100">
                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                Invia
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
require_once 'includes/footer.php';