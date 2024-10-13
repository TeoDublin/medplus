<div class="modal fade" id="preferencesModal" tabindex="-1" aria-labelledby="preferencesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="post/menu.php" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="preferencesModalLabel">Preferenze</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="user" id="form113" class="form-control form-control-lg" name="user"/>
                            <label class="form-label" for="form113">Indirizzo e-mail</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="password" id="form123" class="form-control form-control-lg"  name="password"/>
                            <label class="form-label" for="form123">Password</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <select class="form-select" aria-label="Default select example" id="form133" name="template">
                                <option value="blue" selected>Blue</option>
                                <option value="pink">Pink</option>
                                <option value="dark">Dark</option>
                                <option value="light">Light</option>
                            </select>
                            <label class="form-label" for="form133">Tema</label>
                        </div>
                    </div>            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="vh-100 vw-100 d-flex flex-column">
    <div class="d-flex flex-row mb-1" style="height: 40;">
        <div class="menu-divider">
            <div class="d-flex w-100 justify-content-end">
                <div class="p-3 d-flex align-items-end pe-4" >
                    <img class="menu-icon-back" src="<?php echo icon('minor.svg');?>" alt="menu" width="30" height="30">
                </div>
            </div>
        </div>
        <nav class="navbar w-100 p-0 m-0 bg-secondary shadow-lg" >
            <div class="d-flex  w-100">
                <div class="p-2 d-flex justify-content-center align-items-center" >
                    <img class="menu-icon" src="<?php echo icon('menu.svg');?>" alt="menu" width="30" height="30">
                </div>
                <div class="p-2 pt-3 d-flex justify-content-center align-items-center">
                    <img src="<?php echo image("logo-".theme().".svg");?>" alt="Medplus" height="40">
                </div>
                <div class="p-2 pt-3 me-3 d-flex justify-content-center align-items-center ms-auto">
                    <div class="dropstart">
                        <img class="dots dropdown-toggle" src="<?php echo icon('dots.svg');?>" alt="..." width="40" height="40" data-bs-toggle="dropdown" aria-expanded="false">
                        <ul class="dropdown-menu" style="margin-top: 53px;margin-right:-55px">
                            <li class="menu-setup" data-bs-toggle="modal" data-bs-target="#preferencesModal">
                                <div class="d-flex align-items-center dropdown-item">
                                    <img src="<?php echo icon('person-setup.svg');?>" alt="" >
                                    <h6 class="p-1 mt-1 ms-1">Preferenze</h6>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="menu-exit">
                                <div class="d-flex align-items-center dropdown-item">
                                    <img src="<?php echo icon('exit.svg');?>" alt="" >
                                    <h6 class="p-1 mt-1 ms-1">Esci</h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="d-flex flex-fill">
        <div class="d-flex flex-fill flex-row">
            <div class="menu-vertical h-100 d-flex flex-column p-2">
                <div class="menu-option d-flex w-100 justify-content-start" id="home">
                    <div class="p-3 d-flex align-items-start ps-2" >
                        <img src="<?php echo icon('home.svg');?>" alt="menu" height="30">
                    </div>
                    <div class="menu-label align-self-center" ><span>Home</span></div>
                </div>
                <div class="menu-option d-flex w-100 justify-content-start" id="users">
                    <div class="p-3 d-flex align-items-start ps-2" >
                        <img src="<?php echo icon('person-list.svg');?>" alt="menu" width="31" height="30">
                    </div>
                    <div class="menu-label align-self-center"><span >Utenti</span></div>
                </div>
            </div>
            <div class="page-content flex-fill pb-2 pt-0">
                <div class="d-flex justify-content-center">