
<div class="w-100 mx-1 mt-2">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th><h3>Nome</h3></th>
                        <th><h3>Utente</h3></th>
                        <th><h3>Email</h3></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach(Select('*')->from('view_utenti')->get() as $utente){
                        echo "<tr class=\"hover\" onclick=\"editClick({$utente['id']})\"><td>{$utente['nome']}</td><td>{$utente['user']}</td><td>{$utente['email']}</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>
<div id="utenti"></div>
<?php script('pages/utenti/elenco/elenco.js'); ?>