import '../css/styles.css';

import { initAudits } from './features/audits';
import { initFindings } from './features/findings';
import { initModals } from './lib/ui';

function boot(): void {
    initModals();
    initAudits();
    initFindings();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
    boot();
}
