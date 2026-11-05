<?php
/**
 * @var array<int, array<string, mixed>> $audits
 * @var \CodeIgniter\View\View           $this
 */

$categories = ['HVAC', 'Lighting', 'Controls', 'Envelope', 'Process load', 'Renewables'];
$severities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'];
?>
<dialog id="finding-create-modal" class="modal">
    <div class="modal-box max-w-2xl">
        <form method="dialog">
            <button type="submit" class="btn btn-ghost btn-circle btn-sm absolute right-3 top-3" aria-label="Close">
                &#10005;
            </button>
        </form>

        <h3 class="text-lg font-semibold text-gray-900">Log a finding</h3>
        <p class="mt-1 text-sm text-gray-500">
            Record an observation against an audit. Demo only &mdash; nothing is saved yet.
        </p>

        <form class="mt-5 space-y-4" data-demo-form="finding">
            <label class="block">
                <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Related audit *</span>
                <select name="audit" required class="select w-full">
                    <?php foreach ($audits as $audit): ?>
                        <option value="<?= esc($audit['reference'], 'attr') ?>">
                            <?= esc($audit['reference']) ?> &mdash; <?= esc($audit['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Area / asset *</span>
                    <input
                        type="text"
                        name="area"
                        required
                        maxlength="80"
                        placeholder="AHU-2 / Level 3 plant room"
                        class="input w-full"
                    >
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Category *</span>
                    <select name="category" required class="select w-full">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category, 'attr') ?>"><?= esc($category) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Severity *</span>
                    <select name="severity" required class="select w-full">
                        <?php foreach ($severities as $value => $label): ?>
                            <option value="<?= esc($value, 'attr') ?>" <?= $value === 'medium' ? 'selected' : '' ?>>
                                <?= esc($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Est. annual savings (kWh)</span>
                    <input type="number" name="savings_kwh" min="0" step="100" placeholder="0" class="input w-full">
                </label>

                <label class="block sm:col-span-2">
                    <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Est. annual cost savings ($)</span>
                    <input type="number" name="savings_cost" min="0" step="10" placeholder="0" class="input w-full">
                </label>
            </div>

            <label class="block">
                <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">Observation *</span>
                <textarea
                    name="observation"
                    rows="3"
                    required
                    maxlength="500"
                    placeholder="What was observed, and why does it waste energy?"
                    class="textarea w-full"
                ></textarea>
            </label>

            <div class="modal-action">
                <button type="button" class="btn btn-ghost btn-sm" data-modal-close>Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Log finding</button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
