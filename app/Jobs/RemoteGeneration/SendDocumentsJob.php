<?php

namespace App\Jobs\RemoteGeneration;

use App\Enums\FileTypes;
use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplications;
use App\Services\CryptoHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class SendDocumentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected RgApplications $application;
    private string $base64_of_zip;

    public function __construct($application)
    {
        $this->application = is_int($application) ? RgApplications::whereAcId($application)->first() : $application;
    }

    public function handle()
    {
        try {
            if ($this->createZipArchive() && $this->sendZipArchive()) {
                if ($this->sendSignedZip(
                    $this->signZipArchive()
                )) {
                    $this->application->update(['status' => Statuses::REQUEST_GENERATION()->label]);
                }
            }
        } catch (\Exception $exception) {
            $this->fail($exception);
        }
    }

    public function createZipArchive(): bool
    {
        $zip = new \ZipArchive();
        $applicationId = $this->application->id;
        $zipPath = Storage::path("files/$applicationId") . '/archive.zip';

        if (Storage::exists("files/$applicationId" . '/archive.zip')) {
            Storage::delete("files/$applicationId" . '/archive.zip');

        }

        $isNeedProcuration = $this->isNeedProcuration();

        $filesToAdd = $this->application->files()->where(function ($query) use ($isNeedProcuration) {
            $query->where('type', FileTypes::PASSPORT()->label)
                ->orWhere('type', FileTypes::PHOTO()->label)
                ->orWhere('type', FileTypes::SNILS()->label)
                ->orWhere('type', FileTypes::APPLICATION()->label);

            if ($isNeedProcuration) {
                $query->orWhere('type', FileTypes::PROCURATION()->label);
            }
        });

        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Не удалось добавить файл в архив у заявки' . $this->application->id);
        }

        foreach ($filesToAdd->get() as $file) {
            $filenameForAC = $file->type . '.' . $this->getExtensions($file);
            if (!$zip->addFile(Storage::path($file->path), $filenameForAC)) {
                throw new \Exception('Не удалось добавить файл в архив у заявки' . $this->application->id);
            }
        }
        return $zip->close();
    }

    public function isNeedProcuration(): bool
    {
        $applicant = Str::lower($this->application->template->applicant_fio);
        $director = Str::lower($this->application->template->head_fio);

        return strcmp($applicant, $director) !== 0;
    }

    public function getExtensions($file)
    {
        return Arr::last(explode('.', $file->name));
    }

    public function sendZipArchive(): bool
    {
        $apiUrl = config('AC.API_URL');
        $method = config('AC.METHODS.FILE_ATTACH');
        $applicationId = $this->application->id;
        $this->base64_of_zip = base64_encode(Storage::get("files/$applicationId" . '/archive.zip'));

        return Http::post($apiUrl . $method, [
            'login' => $this->application->ac_login,
            'pass' => $this->application->ac_pass,
            'requestId' => $this->application->ac_id,
            'File_Name' => 'documents.zip',
            'File' => $this->base64_of_zip,
            'FileType' => FileTypes::ZIP()->value
        ])->successful();
    }

    public function sendSignedZip($base64ofSignedZip): bool
    {
        $apiUrl = config('AC.API_URL');
        $method = config('AC.METHODS.FILE_ATTACH');

        return Http::post($apiUrl . $method, [
            'login' => $this->application->ac_login,
            'pass' => $this->application->ac_pass,
            'requestId' => $this->application->ac_id,
            'File_Name' => 'documents.zip.sig',
            'File' => $base64ofSignedZip,
            'FileType' => FileTypes::SIGNED_ZIP()->value
        ])->successful();
    }

    public function signZipArchive()
    {
        $crypto = new CryptoHelper();
        $certs = $crypto->getCertificates(config('PNK.SHA1_OF_SIGN_BY_AC'), null, "My");
        $certs[0]->SetPin(config('PNK.PINCODE_OF_SIGN_BY_AC'));
        return $crypto->SignFile($certs[0], $this->base64_of_zip);
    }

    public function failed($exception)
    {
        Log::alert($exception->getMessage(), ['applicationId' => $this->application->id]);
    }
}
