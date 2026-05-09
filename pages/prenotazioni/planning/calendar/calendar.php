<?php
    style('pages/prenotazioni/planning/calendar/calendar.css');

    $session = Session();
    $elementi = $session->get('elementi') ?? [];
    $ruolo = $session->get('ruolo') ?? false;
    $data = cookie('data', ($_REQUEST['data'] ?? date('Y-m-d')));
    $rows = 53;

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

    $planningCell = function ($idTerapista, $row) use (&$planningByTerapista) {
        $cell = [
            'class' => '',
            'id' => '',
            'motivo' => '',
            'origin' => 'empty',
            'row_span' => 1,
            'stato' => '',
        ];

        foreach (($planningByTerapista[$idTerapista] ?? []) as $plan) {
            $rowInizio = (int)$plan['row_inizio'];
            $rowFine = (int)$plan['row_fine'];
            $stato = $plan['stato'] == '-' ? '' : $plan['stato'];

            if ($rowInizio == $row) {
                $cell['class'] = "{$plan['origin']} {$plan['origin']}_start {$stato}";
            }
            elseif ($row > $rowInizio && $row < $rowFine) {
                $cell['class'] = "{$plan['origin']} {$plan['origin']}_middle {$stato}";
            }
            elseif ($rowFine == $row) {
                $cell['class'] = "{$plan['origin']} {$plan['origin']}_end {$stato}";
            }

            if ($cell['class'] !== '') {
                $cell['id'] = $plan['id'];
                $cell['motivo'] = $plan['motivo'] == 'Vuoto' ? '' : $plan['motivo'];
                $cell['origin'] = $plan['origin'];
                $cell['row_span'] = max(1, (int)$plan['row_span']);
                $cell['stato'] = $stato;
                break;
            }
        }

        return $cell;
    };

    $monthStart = new DateTime(date('Y-m-01', strtotime($data)));
    $calendarStart = clone $monthStart;
    $calendarStart->modify('-' . ((int)$calendarStart->format('N') - 1) . ' days');
    $today = date('Y-m-d');
?>
<div class="planning-calendar-shell">
    <div class="planning-calendar-toolbar">
        <div class="planning-calendar-brand">
            <div class="planning-calendar-icon"><?php echo icon('calendar-check.svg', 'var(--base-bg-primary)', 22, 22); ?></div>
            <div>
                <div class="planning-calendar-title">Calendar</div>
                <div class="planning-calendar-subtitle"><?php echo italian_date($data, '%A %d %B %Y'); ?></div>
            </div>
        </div>
        <div class="planning-calendar-actions">
            <button class="btn btn-light planning-calendar-today" onclick="window.modalHandlers['planning_calendar'].today(this)">Oggi</button>
            <button class="btn btn-light planning-calendar-arrow" onclick="window.modalHandlers['planning_calendar'].removeDay(this)" aria-label="Giorno precedente">
                <?php echo icon('arrow-filled-left.svg', 'black', 22, 22); ?>
            </button>
            <button class="btn btn-light planning-calendar-arrow" onclick="window.modalHandlers['planning_calendar'].addDay(this)" aria-label="Giorno successivo">
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
        <div class="planning-calendar-view-switch">
            <button class="active" type="button">Giorno</button>
            <button type="button">Settimana</button>
            <button type="button">Mese</button>
        </div>
    </div>

    <div class="planning-calendar-layout">
        <aside class="planning-calendar-sidebar">
            <button class="btn btn-primary planning-calendar-create" type="button" onclick="window.modalHandlers['planning_calendar'].create(this)">
                <?php echo icon('calendar-plus.svg', 'white', 18, 18); ?>
                <span>Crea</span>
            </button>

            <div class="planning-calendar-mini">
                <div class="planning-calendar-mini-title"><?php echo italian_date($data, '%B %Y'); ?></div>
                <div class="planning-calendar-mini-grid planning-calendar-mini-week">
                    <span>L</span><span>M</span><span>M</span><span>G</span><span>V</span><span>S</span><span>D</span>
                </div>
                <div class="planning-calendar-mini-grid">
                    <?php
                        $miniDate = clone $calendarStart;
                        for ($i = 0; $i < 42; $i++) {
                            $miniValue = $miniDate->format('Y-m-d');
                            $classes = ['planning-calendar-mini-day'];
                            if ($miniDate->format('m') !== $monthStart->format('m')) $classes[] = 'muted';
                            if ($miniValue === $data) $classes[] = 'selected';
                            if ($miniValue === $today) $classes[] = 'today';
                            ?>
                            <button
                                type="button"
                                class="<?php echo implode(' ', $classes); ?>"
                                data-date="<?php echo $miniValue; ?>"
                                onclick="window.modalHandlers['planning_calendar'].goToDate(this)"
                            ><?php echo $miniDate->format('j'); ?></button>
                            <?php
                            $miniDate->modify('+1 day');
                        }
                    ?>
                </div>
            </div>

            <div class="planning-calendar-legend">
                <div class="planning-calendar-sidebar-title">Legenda</div>
                <button type="button" class="div-color-box planning-calendar-legend-row">
                    <input type="color" class="corso_bg color-box color-picker" data-target="--base-bg-corso">
                    <span>Corso</span>
                </button>
                <button type="button" class="div-color-box planning-calendar-legend-row">
                    <input type="color" class="color-box color-picker" data-target="--base-bg-sbarra">
                    <span>Sbarrato</span>
                </button>
                <button type="button" class="div-color-box planning-calendar-legend-row">
                    <input type="color" class="color-box color-picker" data-target="--base-bg-seduta">
                    <span>Trattamento</span>
                </button>
                <button type="button" class="div-color-box planning-calendar-legend-row">
                    <input type="color" class="color-box color-picker" data-target="--base-bg-colloquio">
                    <span>Colloquio</span>
                </button>
                <div class="planning-calendar-preferences preferences-btn d-none">
                    <button id="planning-calendar-save-btn" class="btn btn-primary btn-sm">Salva</button>
                    <button id="planning-calendar-discard-btn" class="btn btn-secondary btn-sm">Annulla</button>
                </div>
            </div>
        </aside>

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
                        <?php $doingSpan = []; ?>
                        <?php for ($row = 1; $row <= $rows; $row++) { ?>
                            <tr>
                                <th class="planning-calendar-time">
                                    <?php echo planning_calendar_ora($row); ?>
                                </th>
                                <?php
                                    foreach ($terapisti as $terapista) {
                                        $idTerapista = $terapista['id'];
                                        if (!isset($doingSpan[$idTerapista])) $doingSpan[$idTerapista] = 0;

                                        if ($doingSpan[$idTerapista] > 0) {
                                            $doingSpan[$idTerapista]--;
                                            continue;
                                        }

                                        $planning = $planningCell($idTerapista, $row);
                                        $doingSpan[$idTerapista] = $planning['row_span'] - 1;
                                        $canClick = in_array('row_click_planning', $elementi);
                                ?>
                                    <td
                                        rowspan="<?php echo $planning['row_span']; ?>"
                                        class="planning-calendar-slot impegno td <?php echo planning_calendar_h($planning['class']); ?>"
                                        planning_motivi_id="<?php echo planning_calendar_h($planning['id']); ?>"
                                        row="<?php echo $row; ?>"
                                        data-origin="<?php echo planning_calendar_h($planning['origin']); ?>"
                                        data-terapista="<?php echo planning_calendar_h($idTerapista); ?>"
                                        <?php if ($canClick) { ?>
                                            onclick="window.modalHandlers['planning_calendar'].rowClick(this,'<?php echo planning_calendar_h($planning['origin']); ?>','<?php echo planning_calendar_h($idTerapista); ?>');"
                                        <?php } ?>
                                        onmouseenter="window.modalHandlers['planning_calendar'].enterRow(this,'<?php echo planning_calendar_h($planning['origin']); ?>');"
                                    >
                                        <div class="planning-calendar-event">
                                            <?php if ($planning['origin'] !== 'empty') { ?>
                                                <span class="planning-calendar-event-time"><?php echo planning_calendar_ora($row); ?></span>
                                                <span class="planning-calendar-event-title"><?php echo planning_calendar_h($planning['motivo']); ?></span>
                                                <?php if ($planning['stato'] !== '') { ?>
                                                    <span class="planning-calendar-event-status"><?php echo planning_calendar_h($planning['stato']); ?></span>
                                                <?php } ?>
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
