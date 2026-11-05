import { formatMoney, formatNumber, qs, qsa } from '../lib/ui';

/**
 * Recomputes the dashboard KPI cards from the rows currently rendered in the
 * table and findings list, so new demo records are reflected immediately.
 */
export function refreshSummary(): void {
    const rows = qsa<HTMLTableRowElement>('#audit-table-body tr[data-audit-id]');
    const findings = qsa<HTMLLIElement>('#finding-list li[data-finding-id]');

    const activeAudits = rows.filter((row) => row.dataset.status !== 'completed').length;
    const savingsKwh = rows.reduce((total, row) => total + Number(row.dataset.savingsKwh ?? 0), 0);
    const savingsCost = rows.reduce((total, row) => total + Number(row.dataset.savingsCost ?? 0), 0);
    const co2Tonnes = Math.round((savingsKwh * 0.4) / 1000);

    setText('[data-kpi="active-audits"]', String(activeAudits));
    setText('[data-kpi="open-findings"]', String(findings.length));
    setText('[data-kpi="open-findings-list"]', String(findings.length));
    setText('[data-kpi="savings-kwh"]', formatNumber(savingsKwh));
    setText('[data-kpi="savings-cost"]', formatMoney(savingsCost));
    setText('[data-kpi="co2"]', formatNumber(co2Tonnes));
}

function setText(selector: string, value: string): void {
    const node = qs<HTMLElement>(selector);
    if (node) {
        node.textContent = value;
    }
}
