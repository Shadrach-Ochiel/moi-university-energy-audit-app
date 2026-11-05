<?php
/**
 * @var array<int, array<string, mixed>> $facilities
 * @var \CodeIgniter\View\View           $this
 */

$auditTypes = [
    'Walkthrough',
    'ASHRAE Level I',
    'ASHRAE Level II',
    'ASHRAE Level III',
    'Retro-commissioning',
    'Feasibility study',
];

$currentUser = auth()->check() ? (auth()->user()->username ?? auth()->user()->name ?? '') : '';
?>
<dialog id="audit-create-modal" class="modal" data-theme="light">
    <div class="modal-box max-w-2xl">
        <form method="dialog">
            <button type="submit" class="btn btn-ghost btn-circle btn-sm absolute right-3 top-3" aria-label="Close">
                &#10005;
            </button>
        </form>

        <h3 class="text-lg font-semibold text-gray-200">New energy audit</h3>
        <p class="mt-1 text-sm text-gray-500">
            Register a walkthrough or ASHRAE assessment. Demo only &mdash; nothing is saved yet.
        </p>

        <form class="mt-5 space-y-4" data-demo-form="audit">
            <label class="block">
                <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Audit title *</span>
                <input
                    type="text"
                    name="title"
                    required
                    maxlength="120"
                    placeholder="HVAC recommissioning review"
                    class="input w-full"
                >
            </label>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Facility *</span>
                    <select name="facility" required class="select w-full">
                        <?php foreach ($facilities as $facility): ?>
                            <option value="<?= esc($facility['name'], 'attr') ?>">
                                <?= esc($facility['name']) ?> &middot; <?= esc($facility['type']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Audit type *</span>
                    <select name="type" required class="select w-full">
                        <?php foreach ($auditTypes as $type): ?>
                            <option value="<?= esc($type, 'attr') ?>"><?= esc($type) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Lead auditor</span>
                    <input
                        type="text"
                        name="auditor"
                        maxlength="80"
                        value="<?= esc($currentUser, 'attr') ?>"
                        placeholder="Name"
                        class="input w-full"
                    >
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Start date</span>
                    <input type="date" name="started_on" value="<?= date('Y-m-d') ?>" class="input w-full">
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Est. annual savings (kWh)</span>
                    <input type="number" name="savings_kwh" min="0" step="100" placeholder="0" class="input w-full">
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Est. annual cost savings ($)</span>
                    <input type="number" name="savings_cost" min="0" step="10" placeholder="0" class="input w-full">
                </label>
            </div>

            <label class="block">
                <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Scope &amp; notes</span>
                <textarea
                    name="notes"
                    rows="3"
                    maxlength="500"
                    placeholder="Systems in scope, baseline period, metering available…"
                    class="textarea w-full"
                ></textarea>
            </label>

            <div class="modal-action">
                <button type="button" class="btn btn-ghost btn-sm" data-modal-close>Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Create audit</button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
