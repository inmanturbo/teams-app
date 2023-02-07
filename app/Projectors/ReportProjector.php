<?php

namespace App\Projectors;

use App\Models\Report;
use App\StorableEvents\ReportCreated;
use App\StorableEvents\ReportDbTableNameUpdated;
use App\StorableEvents\ReportNameUpdated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class ReportProjector extends Projector
{
    public function onReportCreated(ReportCreated $event)
    {
        $report = Report::create([
            'uuid' => $event->reportUuid,
            'name' => $event->name,
        ]);
    }

    public function onReportNameUpdated(ReportNameUpdated $event)
    {
        $report = Report::whereUuid($event->reportUuid)->first();

        $data = [
            'name' => $event->name,
        ];

        if (isset($event->description)) {
            $data['description'] = $event->description;
        }

        $report->forceFill($data)->save();
    }

    public function onReportDbTableNameUpdated(ReportDbTableNameUpdated $event)
    {
        $report = Report::whereUuid($event->reportUuid)->first();

        $data = [
            'db_table_name' => $event->dbTableName,
        ];


        $data['db_union_table_name'] = $event->dbUnionTableName;


        $report->forceFill($data)->save();
    }
}
