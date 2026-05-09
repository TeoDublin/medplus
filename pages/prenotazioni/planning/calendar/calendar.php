<?php
    style('pages/prenotazioni/planning/calendar/calendar.css');

    $session = Session();
    $elementi = $session->get('elementi') ?? [];
    $ruolo = $session->get('ruolo') ?? false;
    $data = cookie('data', ($_REQUEST['data'] ?? date('Y-m-d')));
    $rows = 53;
    $periodo = cookie('periodo', 'mattina');
    if (!in_array($periodo, ['mattina', 'pomeriggio'])) $periodo = 'mattina';

    $periodi = [
        'mattina' => ['inizio' => 1, 'fine' => 27],
        'pomeriggio' => ['inizio' => 27, 'fine' => 53],
    ];
    $periodoInizio = $periodi[$periodo]['inizio'];
    $periodoFine = $periodi[$periodo]['fine'];

    $terapisti = Select('id, terapista')->from('terapisti')->orderby('id ASC')->get();

    function planning_calendar_ora($row){
        $ora = new DateTime('07:00');
        for ($i = 1; $i < $row; $i++) {
            $ora->add(new DateInterval("PT15M"));
        }
        return $ora->format('H:i');
    }

    function planning_calendar_h($value){
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    function planning_calendar_seduta_colore($idPrenotazione, &$cache){
        if (isset($cache[$idPrenotazione])) return $cache[$idPrenotazione];

        $trattamenti = SQL()->select("
            SELECT tr.id_colore, co.colore
            FROM percorsi_terapeutici_sedute_prenotate sp
            INNER JOIN percorsi_terapeutici_sedute pts ON sp.id_seduta = pts.id
            INNER JOIN percorsi_combo_trattamenti pct ON pts.id_combo = pct.id_combo
            INNER JOIN trattamenti tr ON pct.id_trattamento = tr.id
            LEFT JOIN trattamenti_colori co ON tr.id_colore = co.id
            WHERE sp.id = {$idPrenotazione}
        ");

        if (count($trattamenti) > 1) {
            return $cache[$idPrenotazione] = '#aad5d8';
        }

        return $cache[$idPrenotazione] = ($trattamenti[0]['colore'] ?? '') ?: '#e8eaed';
    }

    function planning_calendar_seduta_acronimo($idPrenotazione, &$cache){
        if (isset($cache[$idPrenotazione])) return $cache[$idPrenotazione];

        $rows = SQL()->select("
            SELECT GROUP_CONCAT(tr.acronimo SEPARATOR ' - ') AS acronimo
            FROM percorsi_terapeutici_sedute_prenotate sp
            INNER JOIN percorsi_terapeutici_sedute pts ON sp.id_seduta = pts.id
            INNER JOIN percorsi_combo_trattamenti pct ON pts.id_combo = pct.id_combo
            INNER JOIN trattamenti tr ON pct.id_trattamento = tr.id
            WHERE sp.id = {$idPrenotazione}
        ");

        return $cache[$idPrenotazione] = $rows[0]['acronimo'] ?? '';
    }

    $planningByTerapista = [];
    foreach ($terapisti as $terapista) {
        $planning = Select('*')
            ->from('view_planning')
            ->where("id_terapista={$terapista['id']}")
            ->and("data='{$data}'");

        if ($ruolo == 'display') {
            $planning->and("( tipo_pagamento IS NULL OR tipo_pagamento <> 'Senza Fattura' )");
        }

        $planningByTerapista[$terapista['id']] = $planning->get();
    }

    $sedutaColori = [];
    $sedutaAcronimi = [];
    $planningCell = function ($idTerapista, $row) use (&$planningByTerapista, &$sedutaColori, &$sedutaAcronimi) {
        $cell = [
            'class' => '',
            'color' => '',
            'id' => '',
            'motivo' => '',
            'origin' => 'empty',
            'stato' => '',
            'time' => planning_calendar_ora($row),
        ];

        foreach (($planningByTerapista[$idTerapista] ?? []) as $plan) {
            $rowInizio = (int)$plan['row_inizio'];
            $rowFine = (int)$plan['row_fine'];
            $stato = $plan['stato'] == '-' ? '' : $plan['stato'];

            if ($rowInizio == $row) {
                $cell['class'] = "{$plan['origin']} {$plan['origin']}_start {$stato}";
                $cell['id'] = $plan['id'];
                $cell['origin'] = $plan['origin'];
                $cell['stato'] = $stato;
                $cell['time'] = planning_calendar_ora($rowInizio) . ($rowFine > $rowInizio ? ' - ' . planning_calendar_ora($rowFine) : '');
                if ($plan['origin'] === 'seduta') {
                    $cell['motivo'] = planning_calendar_seduta_acronimo((int)$plan['id'], $sedutaAcronimi);
                    $cell['color'] = planning_calendar_seduta_colore((int)$plan['id'], $sedutaColori);
                } elseif ($plan['origin'] === 'corso') {
                    $cell['motivo'] = 'Corso';
                } else {
                    $cell['motivo'] = $plan['acronimo'] ?? '';
                }
                break;
            }
        }

        return $cell;
    };

    $displayRows = [];
    $displayRowEnds = [];
    foreach ($planningByTerapista as $planning) {
        foreach ($planning as $plan) {
            $rowInizio = (int)$plan['row_inizio'];
            $rowFine = (int)$plan['row_fine'];
            if ($rowInizio >= $periodoInizio && $rowInizio < $periodoFine) {
                $displayRows[$rowInizio] = true;
                $displayRowEnds[$rowInizio] = max($displayRowEnds[$rowInizio] ?? $rowInizio + 1, $rowFine);
            }
        }
    }

    $displayRows = array_keys($displayRows);
    sort($displayRows);

    $calendarRows = [];
    $cursor = $periodoInizio;
    foreach ($displayRows as $row) {
        if (count($calendarRows) >= 20) break;

        if ($row > $cursor) {
            $calendarRows[] = [
                'type' => 'empty',
                'row' => $cursor,
                'label' => planning_calendar_ora($cursor) . ' - ' . planning_calendar_ora($row),
            ];
        }

        if (count($calendarRows) >= 20) break;

        $calendarRows[] = [
            'type' => 'event',
            'row' => $row,
            'label' => planning_calendar_ora($row),
        ];

        $cursor = max($cursor, min($displayRowEnds[$row] ?? $row + 1, $periodoFine));
    }

    if (count($calendarRows) < 20 && $cursor < $periodoFine) {
        $calendarRows[] = [
            'type' => 'empty',
            'row' => $cursor,
            'label' => planning_calendar_ora($cursor) . ' - ' . planning_calendar_ora($periodoFine),
        ];
    }

    if (empty($calendarRows)) {
        $calendarRows[] = [
            'type' => 'empty',
            'row' => $periodoInizio,
            'label' => planning_calendar_ora($periodoInizio) . ' - ' . planning_calendar_ora($periodoFine),
        ];
    }
?>
<div class="planning-calendar-shell">

    <div class="planning-calendar-toolbar">
        <div class="m-auto d-flex flex-row">
            <input type="hidden" id="planning-calendar-periodo" value="<?php echo planning_calendar_h($periodo); ?>">
            <div class="planning-calendar-period-switch me-2" role="group" aria-label="Periodo giornata">
                <button
                    class="<?php echo $periodo === 'mattina' ? 'active' : ''; ?>"
                    type="button"
                    onclick="window.modalHandlers['planning_calendar'].setPeriodo('mattina')"
                >Mattina</button>
                <button
                    class="<?php echo $periodo === 'pomeriggio' ? 'active' : ''; ?>"
                    type="button"
                    onclick="window.modalHandlers['planning_calendar'].setPeriodo('pomeriggio')"
                >Pomeriggio</button>
            </div>
            <button class="btn btn-light planning-calendar-today  me-2" onclick="window.modalHandlers['planning_calendar'].today(this)">Oggi</button>
            <button class="btn btn-light planning-calendar-arrow  me-2" onclick="window.modalHandlers['planning_calendar'].removeDay(this)" aria-label="Giorno precedente">
                <?php echo icon('arrow-filled-left.svg', 'black', 22, 22); ?>
            </button>
            <button class="btn btn-light planning-calendar-arrow  me-2" onclick="window.modalHandlers['planning_calendar'].addDay(this)" aria-label="Giorno successivo">
                <?php echo icon('arrow-filled-right.svg', 'black', 22, 22); ?>
            </button>
            <input
                type="date"
                id="planning-calendar-data"
                name="data"
                class="form-control planning-calendar-date"
                value="<?php echo planning_calendar_h($data); ?>"
                onchange="window.modalHandlers['planning_calendar'].change(this)"
            />
        </div>
    </div>

    <div class="planning-calendar-layout">
        <main class="planning-calendar-main">
            <div class="planning-calendar-grid-wrap">
                <table class="planning-calendar-grid">
                    <thead>
                        <tr>
                            <th class="planning-calendar-time-head"></th>
                            <?php foreach ($terapisti as $terapista) { ?>
                                <th class="planning-calendar-therapist-head">
                                    <span><?php echo planning_calendar_h($terapista['terapista']); ?></span>
                                </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($calendarRows as $calendarRow) { ?>
                            <?php $row = $calendarRow['row']; ?>
                            <tr class="<?php echo $calendarRow['type'] === 'empty' ? 'planning-calendar-empty-group' : ''; ?>">
                                <th class="planning-calendar-time"><?php echo planning_calendar_h($calendarRow['label']); ?></th>
                                <?php
                                    foreach ($terapisti as $terapista) {
                                        $idTerapista = $terapista['id'];
                                        $planning = $calendarRow['type'] === 'event' ? $planningCell($idTerapista, $row) : [
                                            'class' => '',
                                            'color' => '',
                                            'id' => '',
                                            'motivo' => '',
                                            'origin' => 'empty',
                                            'stato' => '',
                                            'time' => '',
                                        ];
                                        $canClick = in_array('row_click_planning', $elementi);
                                ?>
                                    <td
                                        class="planning-calendar-slot impegno td <?php echo planning_calendar_h($planning['class']); ?>"
                                        planning_motivi_id="<?php echo planning_calendar_h($planning['id']); ?>"
                                        row="<?php echo $row; ?>"
                                        data-origin="<?php echo planning_calendar_h($planning['origin']); ?>"
                                        data-terapista="<?php echo planning_calendar_h($idTerapista); ?>"
                                        <?php if ($planning['color'] !== '') { ?>
                                            style="--planning-calendar-slot-bg: <?php echo planning_calendar_h($planning['color']); ?>;"
                                        <?php } ?>
                                        <?php if ($canClick) { ?>
                                            onclick="window.modalHandlers['planning_calendar'].rowClick(this,'<?php echo planning_calendar_h($planning['origin']); ?>','<?php echo planning_calendar_h($idTerapista); ?>');"
                                        <?php } ?>
                                        onmouseenter="window.modalHandlers['planning_calendar'].enterRow(this,'<?php echo planning_calendar_h($planning['origin']); ?>');"
                                    >
                                        <div class="planning-calendar-event">
                                            <?php if ($planning['origin'] !== 'empty') { ?>
                                                <span class="planning-calendar-event-title"><?php echo planning_calendar_h($planning['motivo']); ?></span>
                                                <span class="planning-calendar-event-time"><?php echo planning_calendar_h($planning['time']); ?></span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<div id="sbarra"></div>
<?php script('pages/prenotazioni/planning/calendar/calendar.js'); ?>
