<!doctype html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="<?php echo '/'.PROJECT_NAME."/assets/css/bootstrap-5.3.3.css?v=".filemtime(root('/assets/css/bootstrap-5.3.3.css'));?>">
        <link rel="stylesheet" href="<?php echo '/'.PROJECT_NAME."/assets/css/style.css?v=".filemtime(root('/assets/css/style.css'));?>">
        <link rel="stylesheet" href="<?php echo '/'.PROJECT_NAME."/assets/css/searchable.css?v=".filemtime(root('/assets/css/searchable.css'));?>">
        <link rel="icon" type="image/x-icon" href="<?php echo '/'.PROJECT_NAME."/favicon.ico?v=".filemtime(root('favicon.ico'));?>">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="<?php echo '/'.PROJECT_NAME.'/assets/js/popper-1.14.7.js?v='.filemtime(root('/assets/js/popper-1.14.7.js'));?>"></script>
        <script src="<?php echo '/'.PROJECT_NAME.'/assets/js/bootstrap-5.3.3.js?v='.filemtime(root('/assets/js/bootstrap-5.3.3.js'));?>"></script>
        <script src="<?php echo '/'.PROJECT_NAME.'/assets/js/functions.js?v='.filemtime(root('/assets/js/functions.js'));?>"></script>
        <script src="<?php echo '/'.PROJECT_NAME.'/assets/js/searchable.js?v='.filemtime(root('/assets/js/searchable.js'));?>"></script>
        <?php require_once __DIR__.'/../assets/css/preferences.php'; ?>
        <title>MedPlus</title>
    </head>
    <body data-bs-theme="<?php echo theme();?>" class="maybe-flex">
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="1500" data-bs-animation="true">
                <div class="toast-header p-0 m-0">
                    <div class="d-flex justify-content-start align-content-center" style="height:40px!important">
                        <div class="p-2"><?php echo icon('square.svg','green',20,20);?></div>
                        <div class="p-2"><h4 class="">Riuscito</h4></div>
                    </div>
                </div>
                <div class="toast-body">Dati aggiornati con successo</div>
            </div>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="failToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false" data-bs-animation="true">
                <div class="toast-header p-0 m-0">
                    <div class="d-flex justify-content-start align-content-center flex-fill" style="height:40px!important">
                        <div class="p-2"><?php echo icon('square.svg','red',20,20);?></div>
                        <div class="p-2"><h4 class="">Non Riuscito</h4></div>
                        <div class="ms-auto align-content-center"><button type="button" class="btn-close me-1 p-2" data-bs-dismiss="toast" aria-label="Close"></button></div>
                    </div>
                    
                </div>
                <div class="toast-body">Riprova</div>
            </div>
        </div>
