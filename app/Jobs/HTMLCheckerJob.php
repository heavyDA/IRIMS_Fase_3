<?php

namespace App\Jobs;

use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use Illuminate\Foundation\Queue\Queueable;
use voku\helper\HtmlDomParser;

class HTMLCheckerJob
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Worksheet::with(
            'identification',
            'strategies',
            'incidents',
            'incidents.mitigations',

            'monitorings',
            'monitorings.actualizations',
        )->chunk(5, function ($worksheets) {
            foreach ($worksheets as $worksheet) {
                $worksheet->identification()->update([
                    'existing_control_body' => HtmlDomParser::str_get_html($worksheet->identification->existing_control_body)->save(),
                    'risk_impact_body' => HtmlDomParser::str_get_html($worksheet->identification->risk_impact_body)->save(),
                    'inherent_body' => HtmlDomParser::str_get_html($worksheet->identification->inherent_body)->save(),
                    'risk_chronology_body' => HtmlDomParser::str_get_html($worksheet->identification->risk_chronology_body)->save(),
                    'risk_chronology_description' => HtmlDomParser::str_get_html($worksheet->identification->risk_chronology_description)->save(),
                ]);

                foreach ($worksheet->incidents as $incident) {
                    $incident->update(['risk_cause_body' => HtmlDomParser::str_get_html($incident->risk_cause_body)->save()]);

                    foreach ($incident->mitigations as $mitigation) {
                        $mitigation->update([
                            'mitigation_plan' => HtmlDomParser::str_get_html($mitigation->mitigation_plan)->save(),
                            'mitigation_output' => HtmlDomParser::str_get_html($mitigation->mitigation_output)->save(),
                        ]);
                    }
                }

                foreach ($worksheet->monitorings as $monitoring) {
                    foreach ($monitoring->actualizations as $actualization) {
                        $actualization->update([
                            'actualization_mitigation_plan' => HtmlDomParser::str_get_html($actualization->actualization_mitigation_plan)->save(),
                            'actualization_plan_explanation' => HtmlDomParser::str_get_html($actualization->actualization_plan_explanation)->save(),
                            'actualization_plan_body' => HtmlDomParser::str_get_html($actualization->actualization_plan_body)->save(),
                            'actualization_plan_output' => HtmlDomParser::str_get_html($actualization->actualization_plan_output)->save(),
                        ]);
                    }
                }
            }
        });
    }
}
