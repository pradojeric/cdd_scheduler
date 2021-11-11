<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;


class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk('backups');

        $files = $disk->files('/CddScheduler');
        $backups = [];
        // make an array of backup files, with their filesize and creation date

        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace('CddScheduler/', '', $f),
                    // 'file_name' => "Ok",
                    'file_size' => $disk->size($f),
                    'last_modified' => $disk->lastModified($f),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);


        return view("pages.configurations.settings.backup")->with(compact('backups'));
    }

    public function create()
    {
        try {
            // start the backup process
            Artisan::call('backup:run', [
                '--only-db' => true,
                '--disable-notifications' => true,
            ]);
            $output = Artisan::output();
            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            // return the results as a response to the ajax call
            session()->flash('success', 'New Backup Created');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($file_name)
    {
        $file = 'CddScheduler/' . $file_name;
        $disk = Storage::disk('backups');
        if ($disk->exists($file)) {
            $fs = Storage::disk('backups')->getDriver();
            $stream = $fs->readStream($file);

            return \Response::stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                "Content-Type" => $fs->getMimetype($file),
                "Content-Length" => $fs->getSize($file),
                "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
            ]);
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $file = 'CddScheduler/' . $file_name;
        $disk = Storage::disk('backups');
        if ($disk->exists($file)) {
            $disk->delete($file);
            session()->flash('success', 'Backup successfully deleted');
            return redirect()->back();
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }
}
