<?php

namespace App;

use App\Contracts\TeamData as ContractsTeamData;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelData\Data;

class TeamData extends Data implements ContractsTeamData
{
    public function __construct(
        public AddressData $address,
        public ?string $name = null,
        public ?string $website = null,
        public ?string $email = null,
        public ?string $landingPage = null,
        public ?string $logoUrl = null,
        public ?string $logoPath = null,
        public ?string $phone = null,
        public ?string $fax = null
    ) {
    }

    public function name(): string
    {
        return $this->name ?? '';
    }

    public function address(): AddressData
    {
        return $this->address;
    }

    public function streetAddress(): string
    {
        $streetAddress = $this->address->street;
        if (isset($this->address->lineTwo) && strlen($this->address->lineTwo) > 1) {
            $streetAddress .= ', ' . $this->address->lineTwo;
        }

        return $streetAddress;
    }

    public function cityStateZip(): string
    {
        if (! isset($this->address->city) || ! isset($this->address->state) || ! isset($this->address->zip) ||
            strlen($this->address->city) < 1 || strlen($this->address->state) < 1 || strlen($this->address->zip) < 1) {
            return '';
        }

        return $this->address->city . ', ' . $this->address->state . ' ' . $this->address->zip;
    }

    public function phone(): string
    {
        return $this->phone ?? config('team.empty_phone');
    }

    public function email(): string
    {
        return $this->email ?? '';
    }

    public function website(): string
    {
        return $this->website ?? '';
    }

    public function logoPath(): string
    {
        return ($this->getLogoDisk())->path($this->logoPath ?? config('team.empty_logo_path'));
    }

    public function logoUrl(): string
    {
        return $this->logoUrl;
    }

    public function fax(): string
    {
        return $this->fax ?? config('team.empty_fax');
    }

    public function landingPage(): string|null
    {
        return $this->landingPage ?? null;
    }

    protected function getLogoDisk()
    {
        return Storage::disk(config('jetstream.profile_photo_disk', 'public'));
    }
}
