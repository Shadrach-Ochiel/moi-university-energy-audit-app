<?php

namespace App\Libraries;

/**
 * Placeholder data for the energy auditing UI.
 *
 * The persistence layer (migrations, models, repositories) has not been
 * designed yet, so views are fed from this in-memory source instead of the
 * database. Replace these methods with repository queries once the schema is
 * agreed on.
 */
class AuditDemoData
{
    /**
     * Facilities in the audit portfolio.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function facilities(): array
    {
        return [
            [
                'id'         => 'fac-alder-house',
                'name'       => 'Alder House HQ',
                'type'       => 'Office',
                'floor_area' => 6850,
                'eui'        => 154,
            ],
            [
                'id'         => 'fac-northgate',
                'name'       => 'Northgate Retail Park',
                'type'       => 'Retail',
                'floor_area' => 9200,
                'eui'        => 205,
            ],
            [
                'id'         => 'fac-riverside',
                'name'       => 'Riverside Distribution Centre',
                'type'       => 'Warehouse',
                'floor_area' => 12400,
                'eui'        => 118,
            ],
            [
                'id'         => 'fac-st-lukes',
                'name'       => "St. Luke's Clinic",
                'type'       => 'Healthcare',
                'floor_area' => 4300,
                'eui'        => 187,
            ],
        ];
    }

    /**
     * Audits currently in the register.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function audits(): array
    {
        return [
            [
                'reference'    => 'AUD-2026-014',
                'title'        => 'HVAC recommissioning & controls review',
                'facility'     => 'Alder House HQ',
                'type'         => 'ASHRAE Level II',
                'auditor'      => 'Amara Osei',
                'started_on'   => '2026-09-14',
                'status'       => 'in_progress',
                'findings'     => 4,
                'savings_kwh'  => 148000,
                'savings_cost' => 21460,
                'progress'     => 65,
            ],
            [
                'reference'    => 'AUD-2026-013',
                'title'        => 'LED retrofit baseline survey',
                'facility'     => 'Northgate Retail Park',
                'type'         => 'ASHRAE Level I',
                'auditor'      => 'Daniel Kariuki',
                'started_on'   => '2026-08-28',
                'status'       => 'completed',
                'findings'     => 6,
                'savings_kwh'  => 96500,
                'savings_cost' => 13900,
                'progress'     => 100,
            ],
            [
                'reference'    => 'AUD-2026-012',
                'title'        => 'Chiller plant optimisation',
                'facility'     => "St. Luke's Clinic",
                'type'         => 'ASHRAE Level III',
                'auditor'      => 'Priya Raman',
                'started_on'   => '2026-10-02',
                'status'       => 'in_progress',
                'findings'     => 2,
                'savings_kwh'  => 61200,
                'savings_cost' => 9480,
                'progress'     => 40,
            ],
            [
                'reference'    => 'AUD-2026-011',
                'title'        => 'Compressed air leak survey',
                'facility'     => 'Riverside Distribution Centre',
                'type'         => 'Walkthrough',
                'auditor'      => 'Amara Osei',
                'started_on'   => '2026-07-19',
                'status'       => 'completed',
                'findings'     => 5,
                'savings_kwh'  => 74300,
                'savings_cost' => 10120,
                'progress'     => 100,
            ],
            [
                'reference'    => 'AUD-2026-015',
                'title'        => 'Rooftop PV feasibility',
                'facility'     => 'Riverside Distribution Centre',
                'type'         => 'Feasibility study',
                'auditor'      => 'Daniel Kariuki',
                'started_on'   => '2026-10-21',
                'status'       => 'planned',
                'findings'     => 0,
                'savings_kwh'  => 0,
                'savings_cost' => 0,
                'progress'     => 10,
            ],
        ];
    }

    /**
     * Most recent observations logged against the audits.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function findings(): array
    {
        return [
            [
                'id'           => 'fnd-1042',
                'audit'        => 'AUD-2026-014',
                'area'         => 'AHU-2 / Level 3 plant room',
                'category'     => 'HVAC',
                'severity'     => 'high',
                'observation'  => '42% of AHU runtime falls outside the 07:00-19:00 occupancy schedule and the static pressure setpoint sits 20% above design.',
                'savings_kwh'  => 38400,
                'savings_cost' => 5570,
                'logged_on'    => '2026-10-28',
            ],
            [
                'id'           => 'fnd-1041',
                'audit'        => 'AUD-2026-012',
                'area'         => 'Chilled water plant',
                'category'     => 'Controls',
                'severity'     => 'high',
                'observation'  => 'Supply temperature reset schedule was overridden during summer maintenance; leaving water temperature is fixed at 6.5 C.',
                'savings_kwh'  => 27600,
                'savings_cost' => 4000,
                'logged_on'    => '2026-10-24',
            ],
            [
                'id'           => 'fnd-1040',
                'audit'        => 'AUD-2026-013',
                'area'         => 'Mall display lighting',
                'category'     => 'Lighting',
                'severity'     => 'medium',
                'observation'  => '61% of display fixtures have no daylight or timer control and run 24/7, including outside trading hours.',
                'savings_kwh'  => 21700,
                'savings_cost' => 3150,
                'logged_on'    => '2026-10-19',
            ],
            [
                'id'           => 'fnd-1039',
                'audit'        => 'AUD-2026-011',
                'area'         => 'Dock doors 4-7',
                'category'     => 'Envelope',
                'severity'     => 'medium',
                'observation'  => 'Three dock levellers show daylight gaps; infiltration is adding roughly 8% to the space conditioning load.',
                'savings_kwh'  => 14900,
                'savings_cost' => 2160,
                'logged_on'    => '2026-10-11',
            ],
            [
                'id'           => 'fnd-1038',
                'audit'        => 'AUD-2026-014',
                'area'         => 'Server room CRAC units',
                'category'     => 'Controls',
                'severity'     => 'low',
                'observation'  => 'CRAC units are set to 18 C with no containment; 24 C is within ASHRAE TC9.9 guidance for this room.',
                'savings_kwh'  => 9800,
                'savings_cost' => 1420,
                'logged_on'    => '2026-10-06',
            ],
        ];
    }

    /**
     * Headline figures for the dashboard.
     *
     * @return array<string, int|float>
     */
    public static function summary(): array
    {
        $audits   = self::audits();
        $findings = self::findings();
        $active   = array_filter($audits, static fn (array $audit): bool => $audit['status'] !== 'completed');

        $savingsKwh  = (int) array_sum(array_column($audits, 'savings_kwh'));
        $savingsCost = (int) array_sum(array_column($audits, 'savings_cost'));

        return [
            'total_audits'  => count($audits),
            'active_audits' => count($active),
            'open_findings' => count($findings),
            'savings_kwh'   => $savingsKwh,
            'savings_cost'  => $savingsCost,
            'co2_tonnes'    => (int) round($savingsKwh * 0.4 / 1000),
            'floor_area'    => (int) array_sum(array_column(self::facilities(), 'floor_area')),
        ];
    }
}
