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
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="d-flex flex-column">
    <div class="d-flex flex-row mb-1 w-100" style="height: 40;">
        <div class="menu-divider hide">
            <div class="d-flex w-100 justify-content-end">
                <div class="p-3 d-flex align-items-end pe-4 menu-icon-back" >
                    <?php echo icon('minor.svg','black',30,30);?>
                </div>
            </div>
        </div>
        <nav class="navbar w-100 p-0 m-0 bg-primary shadow-lg" >
            <div class="d-flex  w-100">
                <div class="p-2 d-flex justify-content-center align-items-center menu-icon" >
                    <?php echo icon('menu.svg','white',30,30);?>
                </div>
                <div class="p-2 pt-3 d-flex justify-content-center align-items-center">
                    <img src="<?php echo image("logo-".theme().".svg");?>" alt="Medplus" height="40">
                </div>
                <div class="p-2 pt-3 me-3 d-flex justify-content-center align-items-center ms-auto">
                    <div class="dropstart">
                        <div class="dots dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo icon('dots.svg','white',40,40);?></div>
                        <ul class="dropdown-menu" style="margin-top: 53px;margin-right:-55px">
                            <li class="menu-setup" data-bs-toggle="modal" data-bs-target="#preferencesModal">
                                <div class="d-flex align-items-center dropdown-item">
                                    <?php echo icon('person-setup.svg');?>
                                    <h6 class="p-1 mt-1 ms-1">Preferenze</h6>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="menu-exit">
                                <div class="d-flex align-items-center dropdown-item">
                                    <?php echo icon('exit.svg');?>
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
            <div class="menu-vertical h-100 d-flex flex-column p-2 hide">
                <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu','prenotazioni')=='prenotazioni'?'menu-active':''?>" id="prenota" title="Prenotazioni">
                    <div class="d-flex align-items-start mx-2" >
                        <?php echo icon('table.svg','black',31,30);?>
                    </div>
                    <div class="menu-label align-self-center hide" ><span>Prenotazioni</span></div>
                </div>
                <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu','prenotazioni')=='fattura'?'menu-active':''?>" id="fattura" title="Fattura">
                    <div class="d-flex align-items-start mx-2" >
                        <?php echo icon('document.svg','black',31,30);?>
                    </div>
                    <div class="menu-label align-self-center hide" ><span>Fattura</span></div>
                </div>
                <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu','prenotazioni')=='impostazioni'?'menu-active':''?>" id="impostazioni" title="impostazioni">
                    <div class="d-flex align-items-start mx-2" >
                        <?php echo icon('gear.svg','black',31,30);?>
                    </div>
                    <div class="menu-label align-self-center hide" ><span>Impostazioni</span></div>
                </div>
                <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu','prenotazioni')=='clienti'?'menu-active':''?>" id="clienti" title="clienti">
                    <div class="d-flex align-items-start mx-2" >
                        <?php echo icon('person-card.svg','black',31,30);?>
                    </div>
                    <div class="menu-label align-self-center hide" ><span>Clienti</span></div>
                </div>                
            </div>
            <div class="page-content flex-fill pb-2 pt-0 px-2">
                <div class="d-flex justify-content-center">