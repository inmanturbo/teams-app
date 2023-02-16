<?php

namespace App\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

trait HasLandingPage
{
    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $page
     * @return void
     */
    public function updateLandingPage(UploadedFile $page)
    {
        tap($this->team_data->landingPage(), function ($previous) use ($page) {
            $this->forceFill([ 'team_data' =>
               $value = array_merge($this->team_data->toArray() ?? [], ['landingPage' => $page->storePublicly('landing-pages', ['disk' => $this->landingPageDisk()]),]),
                ])->save();
            
            // $browserShot = Browsershot::html($page->get())->save(Storage::disk($this->landingPageDisk())
            // ->path($value['landingPage'].'.png'));

            if ($previous) {
                Storage::disk($this->landingPageDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deletelandingPage()
    {
        if (is_null($this->team_data->landingPage())) {
            return;
        }

        Storage::disk($this->landingPageDisk())->delete($this->team_data->landingPage());

        $this->forceFill([ 'team_data' => json_encode(array_merge($this->team_data->toArray(), [
            'landing_page_path' => null,
        ]))])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getLandingPageUrlAttribute()
    {
        return $this->team_data->landingPage()
                    ? str_replace(url(''), '', Storage::disk($this->landingPageDisk())->url($this->team_data->landingPage()))
                    : $this->defaultlandingPageUrl();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getLandingPageThumbUrlAttribute()
    {
        return $this->team_data->landingPage()
                    ? Storage::disk($this->landingPageDisk())->url($this->team_data->landingPage().'.png')
                    : $this->defaultlandingPageUrl();
    }

    public function downloadLandingPage()
    {
        return Storage::disk($this->landingPageDisk())->download($this->team_data->landingPage());
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultlandingPageUrl()
    {
        return url(config('team.default_landing_page_path', '/laravel-welcome'));
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    public function landingPageDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('team.landing_page_disk', 'public');
    }
}
