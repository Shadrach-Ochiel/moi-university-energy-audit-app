import type { AuditStatus } from '../types';
import { closeModal, formatKwh, formatMoney, formValue, qs, toast, toNumber } from '../lib/ui';
import { refreshSummary } from './summary';

const STATUS_LABELS: Record<AuditStatus, string> = {
    planned: 'Planned',
    in_progress: 'In progress',
    completed: 'Completed',
};

const STATUS_CLASSES: Record<AuditStatus, string> = {
    planned: 'badge-ghost',
    in_progress: 'badge-info',
    completed: 'badge-success',
};

interface NewAudit {
    reference: string;
    title: string;
    facility: string;
    type: string;
    auditor: string;
    startedOn: string;
    savingsKwh: number;
    savingsCost: number;
}

/**
 * Handles the "New audit" modal: appends a row to the register and refreshes
 * the KPI cards. Nothing is persisted - the schema is not defined yet.
 */
export function initAudits(): void {
    const dialog = qs<HTMLDialogElement>('#audit-create-modal');
    const form = qs<HTMLFormElement>('form[data-demo-form="audit"]');
    const tbody = qs<HTMLTableSectionElement>('#audit-table-body');

    if (!dialog || !form || !tbody) {
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!form.reportValidity()) {
            return;
        }

        const data = new FormData(form);
        const savingsKwh = toNumber(data.get('savings_kwh'));
        const savingsCost = toNumber(data.get('savings_cost'));

        const audit: NewAudit = {
            reference: nextReference(tbody),
            title: formValue(data, 'title') || 'Untitled audit',
            facility: formValue(data, 'facility'),
            type: formValue(data, 'type'),
            auditor: formValue(data, 'auditor') || 'Unassigned',
            startedOn: formValue(data, 'started_on'),
            savingsKwh,
            savingsCost,
        };

        tbody.prepend(createAuditRow(audit));
        form.reset();
        closeModal(dialog);
        refreshSummary();
        toast(`${audit.reference} added to the register (demo data only).`);
    });
}

function nextReference(tbody: HTMLTableSectionElement): string {
    const year = new Date().getFullYear();
    const highest = Array.from(tbody.querySelectorAll<HTMLTableRowElement>('tr[data-audit-id]'))
        .map((row) => Number.parseInt(row.dataset.auditId?.split('-').pop() ?? '0', 10))
        .filter((value) => Number.isFinite(value))
        .reduce((max, value) => Math.max(max, value), 0);

    return `AUD-${year}-${String(highest + 1).padStart(3, '0')}`;
}

function createAuditRow(audit: NewAudit): HTMLTableRowElement {
    const status: AuditStatus = 'planned';

    const row = document.createElement('tr');
    row.dataset.auditId = audit.reference;
    row.dataset.status = status;
    row.dataset.findings = '0';
    row.dataset.savingsKwh = String(audit.savingsKwh);
    row.dataset.savingsCost = String(audit.savingsCost);

    const auditCell = document.createElement('td');
    const title = document.createElement('p');
    title.className = 'font-medium text-gray-900';
    title.textContent = audit.title;
    const meta = document.createElement('p');
    meta.className = 'text-xs text-gray-500';
    meta.textContent = [audit.reference, audit.type, audit.auditor].filter(Boolean).join(' · ');
    auditCell.append(title, meta);

    const facilityCell = document.createElement('td');
    facilityCell.className = 'text-sm text-gray-900';
    facilityCell.textContent = audit.facility || 'Unassigned';
    const started = document.createElement('span');
    started.className = 'block text-xs text-gray-500';
    started.textContent = audit.startedOn ? `Started ${audit.startedOn}` : 'Not started';
    facilityCell.append(started);

    const statusCell = document.createElement('td');
    const badge = document.createElement('span');
    badge.className = `badge badge-sm ${STATUS_CLASSES[status]}`;
    badge.textContent = STATUS_LABELS[status];
    statusCell.append(badge);

    const findingsCell = document.createElement('td');
    findingsCell.className = 'text-sm text-gray-900';
    findingsCell.dataset.cell = 'findings';
    findingsCell.textContent = '0';

    const savingsCell = document.createElement('td');
    savingsCell.dataset.cell = 'savings';
    const kwh = document.createElement('span');
    kwh.className = 'text-sm font-medium text-gray-900';
    kwh.dataset.cell = 'savings-kwh';
    kwh.textContent = formatKwh(audit.savingsKwh);
    const cost = document.createElement('span');
    cost.className = 'block text-xs text-gray-500';
    cost.dataset.cell = 'savings-cost';
    cost.textContent = `${formatMoney(audit.savingsCost)} / yr`;
    savingsCell.append(kwh, cost);

    const progressCell = document.createElement('td');
    const progress = document.createElement('progress');
    progress.className = 'progress progress-primary w-16 align-middle';
    progress.max = 100;
    progress.value = 0;
    const progressLabel = document.createElement('span');
    progressLabel.className = 'ml-2 align-middle text-xs text-gray-500';
    progressLabel.textContent = '0%';
    progressCell.append(progress, progressLabel);

    row.append(auditCell, facilityCell, statusCell, findingsCell, savingsCell, progressCell);

    return row;
}
