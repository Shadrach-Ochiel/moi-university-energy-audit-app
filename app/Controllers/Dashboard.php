<?php

namespace App\Controllers;

use App\Libraries\AuditDemoData;
use Jengo\Auth\Attributes\Authenticate;

class Dashboard extends BaseController
{
    #[Authenticate]
    public function index(): string
    {
        return page('dashboard', [
            'title'      => 'Energy audit dashboard',
            'audits'     => AuditDemoData::audits(),
            'findings'   => AuditDemoData::findings(),
            'facilities' => AuditDemoData::facilities(),
            'summary'    => AuditDemoData::summary(),
        ]);
    }
}
