<div class=" w-100 mx-1">
    <div class="card p">
        <?php html()->table(['Utente', 'Email di ricupero'],Users()->select_for_table(['select'=>['u_id','u_user','u_email']]));?>
    </div>
</div>        