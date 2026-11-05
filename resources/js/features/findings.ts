import type { Severity } from '../types';
import { closeModal, formatKwh, formatMoney, formValue, qs, qsa, toast, toNumber } from '../lib/ui';
import { refreshSummary } from './summary';

const SEVERITY_LABELS: Record<Severity, string> = {
    low: 'Low',
    medium: 'Medium',
    high: 'High',
};

const SEVERITY_CLASSES: Record<Severity, string> = {
    low: 'badge-info',
    medium: 'badge-warning',
    high: 'badge-error',
};

interface NewFinding {
    audit: string;
    area: string;
    category: string;
    severity: Severity;
    observation: string;
    savingsKwh: number;
    savingsCost: number;
}

/**
 * Handles the "Log finding" modal: prepends the observation to the findings
 * feed and rolls its savings up into the matching audit row.
 */
export function initFindings(): void {
    const dialog = qs<HTMLDialogElement>('#finding-create-modal');
    const form = qs<HTMLFormElement>('form[data-demo-form="finding"]');
    const list = qs<HTMLUListElement>('#finding-list');

    if (!dialog || !form || !list) {
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!form.reportValidity()) {
            return;
        }

        const data = new FormData(form);
        const finding: NewFinding = {
            audit: formValue(data, 'audit'),
            area: formValue(data, 'area') || 'Unassigned area',
            category: formValue(data, 'category'),
            severity: normalizeSeverity(formValue(data, 'severity')),
            observation: formValue(data, 'observation'),
            savingsKwh: toNumber(data.get('savings_kwh')),
            savingsCost: toNumber(data.get('savings_cost')),
        };

        list.prepend(createFindingItem(finding));
        rollUpToAudit(finding);
        form.reset();
        closeModal(dialog);
        refreshSummary();
        toast('Finding logged against ' + finding.audit + ' (demo data only).');
    });
}

function normalizeSeverity(value: string): Severity {
    return value === 'low' || value === 'high' ? value : 'medium';
}

function createFindingItem(finding: NewFinding): HTMLLIElement {
    const item = document.createElement('li');
    item.className = 'px-5 py-4';
    item.dataset.findingId = `fnd-${Date.now()}`;
    item.dataset.severity = finding.severity;

    const header = document.createElement('div');
    header.className = 'flex items-start justify-between gap-3';

    const textWrap = document.createElement('div');
    const area = document.createElement('p');
    area.className = 'text-sm font-medium text-gray-900';
    area.textContent = finding.area;
    const observation = document.createElement('p');
    observation.className = 'mt-1 text-xs text-gray-500';
    observation.textContent = finding.observation;
    textWrap.append(area, observation);

    const badge = document.createElement('span');
    badge.className = `badge badge-sm shrink-0 ${SEVERITY_CLASSES[finding.severity]}`;
    badge.textContent = SEVERITY_LABELS[finding.severity];

    header.append(textWrap, badge);

    const meta = document.createElement('p');
    meta.className = 'mt-2 text-xs text-gray-500';
    meta.textContent = [
        finding.audit,
        finding.category,
        formatKwh(finding.savingsKwh),
        formatMoney(finding.savingsCost),
    ]
        .filter(Boolean)
        .join(' · ');

    item.append(header, meta);

    return item;
}

function rollUpToAudit(finding: NewFinding): void {
    const row = qsa<HTMLTableRowElement>('#audit-table-body tr[data-audit-id]').find(
        (candidate) => candidate.dataset.auditId === finding.audit,
    );

    if (!row) {
        return;
    }

    const findings = Number(row.dataset.findings ?? 0) + 1;
    row.dataset.findings = String(findings);
    const findingsCell = row.querySelector<HTMLElement>('[data-cell="findings"]');
    if (findingsCell) {
        findingsCell.textContent = String(findings);
    }

    const totalKwh = Number(row.dataset.savingsKwh ?? 0) + finding.savingsKwh;
    const totalCost = Number(row.dataset.savingsCost ?? 0) + finding.savingsCost;
    row.dataset.savingsKwh = String(totalKwh);
    row.dataset.savingsCost = String(totalCost);

    const kwhCell = row.querySelector<HTMLElement>('[data-cell="savings-kwh"]');
    if (kwhCell) {
        kwhCell.textContent = formatKwh(totalKwh);
    }

    const costCell = row.querySelector<HTMLElement>('[data-cell="savings-cost"]');
    if (costCell) {
        costCell.textContent = `${formatMoney(totalCost)} / yr`;
    }
}
