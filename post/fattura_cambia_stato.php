<?php
    $_REQUEST['skip_cookie']=true;
    require_once '../includes.php';
    function _percorsi(){
        return Select("f.data as 'data_fattura',pf.*")
            ->from('pagamenti_fatture','pf')
            ->left_join('fatture f ON pf.id_fattura = f.id')
            ->where("pf.id_fattura={$_REQUEST['id']}")->get();
    }

    function _stato_pagamento($percorsi_terapeutici_sedute){
        
        if($_REQUEST['stato']=='Pendente'){
            return 'Fatturato';
        }

        if($percorsi_terapeutici_sedute['saldato']>=$percorsi_terapeutici_sedute['prezzo']){
            return 'Saldato';
        }

        return 'Parziale';
    }

    Update('fatture')->set(['stato'=>$_REQUEST['stato']])->where("id={$_REQUEST['id']}");
    foreach (_percorsi() as $percorso) {
        if($percorso['origine']=='trattamenti'){

            $percorsi_terapeutici_sedute=Select('*')->from('percorsi_terapeutici_sedute')->where("id={$percorso['id_origine_child']}")->first_or_false();

            if(!$percorsi_terapeutici_sedute){
                throw new Exception("Error Processing Request", 1);
            }

            Update('percorsi_terapeutici_sedute')->set([
                'data_pagamento'=>$percorso['data_fattura'],
                'stato_pagamento'=>_stato_pagamento($percorsi_terapeutici_sedute)
            ])->where("id={$percorsi_terapeutici_sedute['id']}");
        }

    }
