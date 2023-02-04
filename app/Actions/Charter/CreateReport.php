<?php

namespace App\Actions\Charter;

use App\Aggregates\ReportAggregate;
use App\Contracts\CreatesReport;
use App\Models\Report;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateReport implements CreatesReport
{
    public $reportUuid;

    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Report::class);

        Validator::make($input, [
            'name' => 'required|max:255|unique:reports,name',
        ])->validateWithBag('createReport');

        $reportUuid = Str::uuid();

        $reportAggregate = ReportAggregate::retrieve($reportUuid);

        $reportAggregate->createReport(
            name: $input['name']
        )->persist();

        $this->reportUuid = $reportUuid;
    }

    public function redirectTo()
    {
        return route('reports.show', $this->reportUuid);
    }
}
