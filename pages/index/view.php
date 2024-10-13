
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <img src=<?php echo Session()->get('template')->images['login'] ?? image('login-blue.svg');?> class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <form action="index.php" method="post">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="form113" class="form-control form-control-lg" name="user"/>
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
                </form>
            </div>
        </div>
    </div>
</section>        
<?php if(is_submit()&&!is_logged())html()->alert('user o Password errata, riprova');?>
