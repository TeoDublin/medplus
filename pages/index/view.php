
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src=<?php echo Session()->get('template')->images['login'] ?? image('login-blue.svg');?> class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form action="index.php" method="post">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="form113" class="form-control form-control-lg" name="email"/>
                        <label class="form-label" for="form113">Indirizzo e-mail</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="form123" class="form-control form-control-lg"  name="password"/>
                        <label class="form-label" for="form123">Password</label>
                    </div>
                    <div class="d-flex justify-content-around align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="form13" checked />
                            <label class="form-check-label" for="form13"> Ricordati di me </label>
                        </div>
                        <a href="#!">Ha dimenticato la password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-2" name="submit">Avanti</button>
                    <div class="divider d-flex justify-content-center align-items-center my-4"><p class="text-center fw-bold mx-3 mb-0 text-muted">O</p></div>
                    <a data-mdb-ripple-init class="btn btn-secondary btn-lg w-100 mb-2" href="#!" role="button">
                        <i class="fab fa-facebook-f me-2"></i> Continua con Facebook
                    </a>
                    <a data-mdb-ripple-init class="btn btn-tertiary btn-lg w-100 mb-2" href="#!" role="button">
                        <i class="fab fa-google me-2"></i> Continua con Google
                    </a>
                </form>
            </div>
        </div>
    </div>
</section>        
<?php if(is_submit()&&!is_logged())html()->alert('Email o Password errata, riprova');?>
