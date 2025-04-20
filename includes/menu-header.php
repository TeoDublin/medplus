<div class="d-flex flex-column">
    <div class="d-flex flex-row w-100 sticky-top" style="height: 40;">
        <div class="menu-divider hide">
            <div class="d-flex w-100 justify-content-end">
                <div class="p-3 d-flex align-items-end pe-4 menu-icon-back" >
                    <?php echo icon('minor.svg','black',30,30);?>
                </div>
            </div>
        </div>
        <nav class="navbar w-100 p-0 m-0 bg-primary shadow-lg" >
            <div class="d-flex  w-100">
                <div class="p-2 justify-content-center align-items-center menu-icon" 
                    onclick="">
                    <?php echo icon('menu.svg','white',41,41);?>
                </div>
                <div class="p-2 pt-3 d-flex justify-content-center align-items-center">
                    <img src="<?php echo image("logo-".theme().".svg");?>" alt="Medplus" height="40">
                </div>
                <div class="p-2 pt-3 me-3 d-flex justify-content-center align-items-center ms-auto">
                    <div class="dropstart" style="z-index:1160!important">
                        <div class="dots dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?php echo icon('dots.svg','white',40,40);?></div>
                        <ul class="dropdown-menu dots-dropdown">
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
        <div class="d-flex flex-fill flex-column flex-md-row">
            <div class="menu-vertical hide bg-white"><?php 
                $session??=Session();
                $elementi??=$session->get('elementi')??[];
                $home=$session->get('home');
                if(in_array('menu_prenotazioni',$elementi)){?>
                    <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu_page',$home)=='prenotazioni'?'menu-active':''?>" id="menu-prenota" title="Prenotazioni">
                        <div class="d-flex align-items-start mx-2" >
                            <?php echo icon('table.svg','black',31,30);?>
                        </div>
                        <div class="menu-label align-self-center hide" ><span>Prenotazioni</span></div>
                    </div><?php
                }
                if(in_array('menu_pagamenti',$elementi)){?>
                    <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu_page',$home)=='pagamenti'?'menu-active':''?>" id="menu-pagamenti" title="pagamenti">
                        <div class="d-flex align-items-start mx-2" >
                            <?php echo icon('coin.svg','black',31,30);?>
                        </div>
                        <div class="menu-label align-self-center hide" ><span>Pagamenti</span></div>
                    </div><?php                     
                } 
                if(in_array('menu_terapisti',$elementi)){?>
                    <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu_page',$home)=='terapisti'?'menu-active':''?>" id="menu-terapisti" title="terapisti">
                        <div class="d-flex align-items-start mx-2" >
                            <?php echo icon('stetoscope.svg','black',31,30);?>
                        </div>
                        <div class="menu-label align-self-center hide" ><span>terapisti</span></div>
                    </div><?php                     
                }
                if(in_array('menu_clienti',$elementi)){?>
                    <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu_page',$home)=='clienti'?'menu-active':''?>" id="menu-clienti" title="clienti">
                        <div class="d-flex align-items-start mx-2" >
                            <?php echo icon('person-card.svg','black',31,30);?>
                        </div>
                        <div class="menu-label align-self-center hide" ><span>Clienti</span></div>
                    </div><?php 
                }
                if(in_array('menu_trattamenti',$elementi)){?>
                    <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu_page',$home)=='trattamenti'?'menu-active':''?>" id="menu-trattamenti" title="trattamenti">
                        <div class="d-flex align-items-start mx-2" >
                            <?php echo icon('heart.svg','black',31,30);?>
                        </div>
                        <div class="menu-label align-self-center hide" ><span>Trattamenti</span></div>
                    </div><?php                    
                }
                if(in_array('menu_corsi',$elementi)){
                    $to_do=Select('
                        SUM(IF(`1`=4,1,0)) +
                        SUM(IF(`2`=4,1,0)) +
                        SUM(IF(`3`=4,1,0)) +
                        SUM(IF(`4`=4,1,0)) +
                        SUM(IF(`5`=4,1,0)) +
                        SUM(IF(`7`=4,1,0)) +
                        SUM(IF(`8`=4,1,0)) +
                        SUM(IF(`9`=4,1,0)) +
                        SUM(IF(`10`=4,1,0)) +
                        SUM(IF(`11`=4,1,0)
                    ) AS to_do')
                    ->from('view_corsi_pagamenti')
                    ->col('to_do');
                    ?>
                    <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu_page',$home)=='corsi'?'menu-active':''?>" id="menu-corsi" title="corsi">
                        <div class="d-flex align-items-start mx-2 position-relative" >
                            <?php 
                                echo icon('people-arms.svg','black',31,30);
                                if($to_do){
                                    echo "<span class=\"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger\">".
                                        "{$to_do}".
                                        "<span class=\"visually-hidden\">Pendenti di Conferma</span>".
                                    "</span>";
                                }
                            ?>
                        </div>
                        <div class="menu-label align-self-center hide" ><span>Corsi</span></div>
                    </div><?php        
                }
                if(in_array('menu_utenti',$elementi)){?>
                    <div class="menu-option d-flex w-100 justify-content-start py-3 <?php echo cookie('menu_page',$home)=='utenti'?'menu-active':''?>" id="menu-utenti" title="utenti">
                        <div class="d-flex align-items-start mx-2" >
                            <?php echo icon('person-setup.svg','black',31,30);?>
                        </div>
                        <div class="menu-label align-self-center hide" ><span>Utenti</span></div>
                    </div><?php 
                }?>
                
            </div>
            <div class="page-content menu-hidden">
                <div class="justify-content-center">