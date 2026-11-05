<?php
/**
 * @var array<int, array<string, mixed>> $audits
 * @var array<int, array<string, mixed>> $findings
 * @var array<int, array<string, mixed>> $facilities
 * @var array<string, int|float>         $summary
 * @var \CodeIgniter\View\View           $this
 */

$statusBadges = [
    'planned'     => ['label' => 'Planned', 'class' => 'badge-ghost'],
    'in_progress' => ['label' => 'In progress', 'class' => 'badge-info'],
    'completed'   => ['label' => 'Completed', 'class' => 'badge-success'],
];

$severityBadges = [
    'high'   => ['label' => 'High', 'class' => 'badge-error'],
    'medium' => ['label' => 'Medium', 'class' => 'badge-warning'],
    'low'    => ['label' => 'Low', 'class' => 'badge-info'],
];
?>
<?= $this->extend('layouts/app.layout.php') ?>

<?= $this->section('main') ?>
<div class="py-8">
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

        <!-- Page heading -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-primary">Portfolio overview</p>
                <h1 class="mt-1 text-2xl font-semibold text-gray-900">Energy audits - Editted</h1>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Walkthroughs, ASHRAE assessments and the savings they have identified across
                    <?= number_format((int) $summary['floor_area']) ?> m&sup2; of floor area.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn btn-ghost btn-sm" data-modal-open="finding-create-modal">
                    Log finding
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-modal-open="audit-create-modal">
                    New audit
                </button>
            </div>
        </div>

        <!-- Key figures -->
        <section class="stats stats-vertical w-full border border-base-300 bg-base-100 shadow-sm lg:stats-horizontal">
            <div class="stat">
                <div class="stat-title">Active audits</div>
                <div class="stat-value text-2xl" data-kpi="active-audits"><?= (int) $summary['active_audits'] ?></div>
                <div class="stat-desc"><?= (int) $summary['total_audits'] ?> audits in the register</div>
            </div>
            <div class="stat">
                <div class="stat-title">Open findings</div>
                <div class="stat-value text-2xl text-warning" data-kpi="open-findings"><?= (int) $summary['open_findings'] ?></div>
                <div class="stat-desc">Awaiting owner sign-off</div>
            </div>
            <div class="stat">
                <div class="stat-title">Identified savings</div>
                <div class="stat-value text-2xl text-primary" data-kpi="savings-kwh"><?= number_format((int) $summary['savings_kwh']) ?></div>
                <div class="stat-desc">
                    kWh / yr &middot; <span data-kpi="savings-cost">$<?= number_format((int) $summary['savings_cost']) ?></span> per year
                </div>
            </div>
            <div class="stat">
                <div class="stat-title">CO&sup2;e avoided</div>
                <div class="stat-value text-2xl text-success" data-kpi="co2"><?= (int) $summary['co2_tonnes'] ?></div>
                <div class="stat-desc">tonnes / yr at 0.4 kg per kWh</div>
            </div>
        </section>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

            <!-- Audit register -->
            <section class="rounded-box border border-base-300 bg-base-100 shadow-sm xl:col-span-2">
                <div class="flex items-center justify-between gap-3 border-b border-base-300 px-5 py-4">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Audit register</h2>
                        <p class="text-xs text-gray-500">Placeholder records until the schema is defined.</p>
                    </div>
                    <button type="button" class="btn btn-primary btn-xs sm:btn-sm" data-modal-open="audit-create-modal">
                        New audit
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-sm">
                        <thead class="text-[0.7rem] uppercase tracking-wide text-gray-500">
                            <tr>
                                <th scope="col">Audit</th>
                                <th scope="col">Facility</th>
                                <th scope="col">Status</th>
                                <th scope="col">Findings</th>
                                <th scope="col">Savings</th>
                                <th scope="col">Progress</th>
                            </tr>
                        </thead>
                        <tbody id="audit-table-body">
                            <?php foreach ($audits as $audit): ?>
                                <?php $status = $statusBadges[$audit['status']] ?? $statusBadges['planned']; ?>
                                <tr
                                    data-audit-id="<?= esc($audit['reference'], 'attr') ?>"
                                    data-status="<?= esc($audit['status'], 'attr') ?>"
                                    data-findings="<?= (int) $audit['findings'] ?>"
                                    data-savings-kwh="<?= (int) $audit['savings_kwh'] ?>"
                                    data-savings-cost="<?= (int) $audit['savings_cost'] ?>"
                                >
                                    <td>
                                        <p class="font-medium text-gray-900"><?= esc($audit['title']) ?></p>
                                        <p class="text-xs text-gray-500">
                                            <?= esc($audit['reference']) ?> &middot; <?= esc($audit['type']) ?> &middot; <?= esc($audit['auditor']) ?>
                                        </p>
                                    </td>
                                    <td class="text-sm text-gray-900">
                                        <?= esc($audit['facility']) ?>
                                        <span class="block text-xs text-gray-500">Started <?= esc($audit['started_on']) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm <?= esc($status['class'], 'attr') ?>"><?= esc($status['label']) ?></span>
                                    </td>
                                    <td class="text-sm text-gray-900" data-cell="findings"><?= (int) $audit['findings'] ?></td>
                                    <td data-cell="savings">
                                        <span class="text-sm font-medium text-gray-900" data-cell="savings-kwh"><?= number_format((int) $audit['savings_kwh']) ?> kWh</span>
                                        <span class="block text-xs text-gray-500" data-cell="savings-cost">$<?= number_format((int) $audit['savings_cost']) ?> / yr</span>
                                    </td>
                                    <td>
                                        <progress class="progress progress-primary w-16 align-middle" value="<?= (int) $audit['progress'] ?>" max="100"></progress>
                                        <span class="ml-2 align-middle text-xs text-gray-500"><?= (int) $audit['progress'] ?>%</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-base-300 px-5 py-3 text-xs text-gray-500">
                    Demo data &mdash; new records are added to this page only and are not persisted.
                </div>
            </section>

            <!-- Findings feed -->
            <section class="rounded-box border border-base-300 bg-base-100 shadow-sm">
                <div class="flex items-center justify-between gap-3 border-b border-base-300 px-5 py-4">
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Latest findings</h2>
                        <p class="text-xs text-gray-500"><span data-kpi="open-findings-list"><?= count($findings) ?></span> open</p>
                    </div>
                    <button type="button" class="btn btn-ghost btn-xs sm:btn-sm" data-modal-open="finding-create-modal">
                        Log finding
                    </button>
                </div>

                <ul id="finding-list" class="divide-y divide-base-200">
                    <?php foreach ($findings as $finding): ?>
                        <?php $severity = $severityBadges[$finding['severity']] ?? $severityBadges['low']; ?>
                        <li
                            class="px-5 py-4"
                            data-finding-id="<?= esc($finding['id'], 'attr') ?>"
                            data-severity="<?= esc($finding['severity'], 'attr') ?>"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?= esc($finding['area']) ?></p>
                                    <p class="mt-1 text-xs text-gray-500"><?= esc($finding['observation']) ?></p>
                                </div>
                                <span class="badge badge-sm shrink-0 <?= esc($severity['class'], 'attr') ?>"><?= esc($severity['label']) ?></span>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <?= esc($finding['audit']) ?> &middot; <?= esc($finding['category']) ?> &middot;
                                <?= number_format((int) $finding['savings_kwh']) ?> kWh &middot;
                                $<?= number_format((int) $finding['savings_cost']) ?>
                            </p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
    </div>
</div>

<div id="toast-region" class="toast toast-end toast-bottom z-50"></div>

<?= $this->include('pages/partials/audit-create.modal.partial.php') ?>
<?= $this->include('pages/partials/finding-create.modal.partial.php') ?>
<?= $this->endSection() ?>
