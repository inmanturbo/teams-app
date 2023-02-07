<?php

namespace App\Aggregates;

use App\StorableEvents\ReportCreated;
use App\StorableEvents\ReportDbTableNameUpdated;
use App\StorableEvents\ReportNameUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class ReportAggregate extends AggregateRoot
{
    public function createReport(
        string $name,
    ) {
        $this->recordThat(new ReportCreated(
            reportUuid: $this->uuid(),
            name: $name,
        ));

        return $this;
    }

    public function updateReportName(
        string $name,
        ?string $description = null,
    ) {
        $this->recordThat(new ReportNameUpdated(
            $this->uuid(),
            name: $name,
            description: $description,
        ));

        return $this;
    }

    public function updateReportDbTableName(
        string $dbTableName,
        ?string $dbUnionTableName = null,
    ) {
        $this->recordThat(new ReportDbTableNameUpdated(
            reportUuid: $this->uuid(),
            dbTableName: $dbTableName,
            dbUnionTableName: $dbUnionTableName,
        ));

        return $this;
    }
}
