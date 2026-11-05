/**
 * Small DOM/UI helpers shared by the dashboard features.
 */

export function qs<T extends Element>(selector: string, root: ParentNode = document): T | null {
    return root.querySelector<T>(selector);
}

export function qsa<T extends Element>(selector: string, root: ParentNode = document): T[] {
    return Array.from(root.querySelectorAll<T>(selector));
}

export function openModal(id: string): void {
    const dialog = document.getElementById(id);
    if (dialog instanceof HTMLDialogElement && !dialog.open) {
        dialog.showModal();
    }
}

export function closeModal(dialog: HTMLDialogElement): void {
    if (dialog.open) {
        dialog.close();
    }
}

/**
 * Wires up every `[data-modal-open]`, `[data-modal-close]` and backdrop click.
 */
export function initModals(): void {
    document.addEventListener('click', (event) => {
        const target = event.target;
        if (!(target instanceof Element)) {
            return;
        }

        const opener = target.closest<HTMLElement>('[data-modal-open]');
        if (opener?.dataset.modalOpen) {
            openModal(opener.dataset.modalOpen);
            return;
        }

        const closer = target.closest<HTMLElement>('[data-modal-close]');
        if (closer) {
            closer.closest<HTMLDialogElement>('dialog')?.close();
        }
    });

    // Clicking the dimmed backdrop (the dialog box itself) closes the dialog.
    qsa<HTMLDialogElement>('dialog.modal').forEach((dialog) => {
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) {
                dialog.close();
            }
        });
    });
}

export function toast(message: string, variant: 'success' | 'error' = 'success'): void {
    const region = qs<HTMLElement>('#toast-region');
    if (!region) {
        return;
    }

    const alert = document.createElement('div');
    alert.className = `alert alert-${variant} shadow-lg`;
    alert.setAttribute('role', 'status');

    const text = document.createElement('span');
    text.textContent = message;
    alert.append(text);

    region.append(alert);
    window.setTimeout(() => alert.remove(), 4000);
}

const numberFormat = new Intl.NumberFormat('en-US', { maximumFractionDigits: 0 });
const moneyFormat = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    maximumFractionDigits: 0,
});

export function formatNumber(value: number): string {
    return numberFormat.format(value);
}

export function formatKwh(value: number): string {
    return `${formatNumber(value)} kWh`;
}

export function formatMoney(value: number): string {
    return moneyFormat.format(value);
}

export function toNumber(value: FormDataEntryValue | null): number {
    const parsed = Number.parseFloat(String(value ?? '').replace(/[^0-9.-]/g, ''));

    return Number.isFinite(parsed) ? parsed : 0;
}

export function formValue(data: FormData, name: string): string {
    return String(data.get(name) ?? '').trim();
}
