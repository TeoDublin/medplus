<?php
    component('search_table','css');
    component('search_table','js');
    $response=json_decode($_REQUEST['response']);
    $actions=$response->actions?htmlspecialchars($response->actions??[], ENT_QUOTES, 'UTF-8'):json_encode([]);
    $cols=htmlspecialchars(json_encode($response->cols??[]), ENT_QUOTES, 'UTF-8');
?>
<div class="card p">
    <div class="card-body d-flex flex-column">
        <div class="p-2 border my-1" style="border-bottom: 0px!important;border-radius: 10px 10px 0 0;">
            <table class="table table-striped border-0">
                <thead>
                    <tr class="align-middle"><?php 
                        foreach ($response->cols as $col) if($col!='id'){
                            echo "<th scope=\"col\" class=\"text-center\" rowspan=\"2\">
                                    <div class=\"d-flex flex-row search_row\">
                                        <input type=\"text\" class=\"search_input text-center\" value=\"{$col}\" data-value=\"{$col}\"
                                            onmouseenter=\"window.modalHandlers['search_table'].enterSearchInput(this);\"
                                            onmouseleave=\"window.modalHandlers['search_table'].leaveSearchInput(this);\"
                                            oninput=\"window.modalHandlers['search_table'].searchTableBody('{$_REQUEST['table']}','{$col}',this,{$actions},{$cols})\"
                                        />
                                    </div>
                                </th>";
                        }
                        foreach ($_REQUEST['actions']??[] as $key=>$value)echo "<th scope=\"col\" class=\"text-center\" rowspan=\"2\">{$key}</th>";?>
                        <th scope="col" class="text-center" rowspan="2">#</th>
                    </tr>
                </thead>
                <tbody id="search_table_body"></tbody>
            </table>
        </div>
    </div>
    <?php html()->pagination($response);?>
</div>