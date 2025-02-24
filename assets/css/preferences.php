<style>
    <?php 
        $session=Session();
        if(($user_id=$session->get('user_id'))){
            foreach(Select('*')->from('utenti_preferenze')->where("id_utente={$user_id}")->get() as $p){
                echo $p['valore'];
            }
        }
    ?>
</style>