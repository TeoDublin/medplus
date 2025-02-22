<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    $view_trattamenti=Select('*')->from('view_trattamenti')->where("id={$_REQUEST['id_trattamento']}")->first();
    echo "
        <div class=\"p-1 flex-fill text-center\">
            <select class=\"form-control text-center\" name=\"id_trattamento\" value=\"".$view_trattamenti['id']."\" disabled>
                <option value=\"".$view_trattamenti['id']."\" selected>".$view_trattamenti['trattamento']."</option>
            </select>
        </div>
        <div class=\"p-1 w-15 text-center\">
            <input type=\"text\" class=\"form-control text-center\" name=\"row_acronimo\" value=\"".$view_trattamenti['acronimo']."\" disabled/>
        </div>
        <div class=\"p-1 w-20 text-center\">
            <input type=\"number\" class=\"form-control text-center\" name=\"row_prezzo_tabellare\" value=\"".$view_trattamenti['prezzo']."\" disabled/>
        </div>
        <div class=\"p-1 w-20 text-center\">
            <input type=\"number\" class=\"form-control text-center\" name=\"row_prezzo\" prezzo_tabellare=\"".$view_trattamenti['prezzo']."\" value=\"".$view_trattamenti['prezzo']."\" disabled/>
        </div>
        <div class=\"p-1 w-10 text-center justify-content-center align-content-center\"
            onmouseenter=\"window.modalHandlers['percorso_combo'].delEnter(this)\"
            onmouseleave=\"window.modalHandlers['percorso_combo'].delLeave(this)\"
            onclick=\"window.modalHandlers['percorso_combo'].delClick(this)\">
            <button class=\"btn\">".icon('bin.svg','black',16,16)."</button>
        </div>
    ";