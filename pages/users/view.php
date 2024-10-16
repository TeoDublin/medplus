<div class=" w-100 mx-1">
    <div class="card p">
        <?php html()->table(['Utente', 'Email di ricupero'],Users()->select_for_table(['select'=>['id','user','email']]));?>
    </div>
</div>        