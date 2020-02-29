<?php

namespace App\Utilities;

use App\Models\Module\Module as ModuleModel;
use App\Traits\SiteApi;
use App\Utilities\Console;
use Artisan;
use Cache;
use Date;
use File;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;
use Module;
use ZipArchive;

class Updater
{
    use SiteApi;

    public static function clear()
    {
        Artisan::call('cache:clear');

        return true;
    }

    public static function download($alias, $new, $old)
    {
        $file = null;
        $path = null;

        // Check core first
        $info = Info::all();

        if ($alias == 'core') {
            $url = 'core/download/' . $new . '/' . $info['php'] . '/' . $info['mysql'];
        } else {
            $url = 'apps/' . $alias . '/download/' . $new . '/' . $info['akaunting'] . '/' . $info['token'];
        }

        $response = static::getRemote($url, ['timeout' => 50, 'track_redirects' => true]);

        // Exception
        if (!$response || ($response instanceof RequestException) || ($response->getStatusCode() != 200)) {
            \Log::info(trans('modules.errors.download', ['module' => $alias]));
            throw new \Exception(trans('modules.errors.download', ['module' => $alias]));
        }

        $file = $response->getBody()->getContents();

        $path = 'temp-' . md5(mt_rand());
        $temp_path = storage_path('app/temp') . '/' . $path;

        $file_path = $temp_path . '/upload.zip';

        // Create tmp directory
        if (!File::isDirectory($temp_path)) {
            File::makeDirectory($temp_path);
        }

        // Add content to the Zip file
        $uploaded = is_int(file_put_contents($file_path, $file)) ? true : false;

        if (!$uploaded) {
            throw new \Exception(trans('modules.errors.zip', ['module' => $alias]));
        }

        return $path;
    }

    public static function unzip($path, $alias, $new, $old)
    {
        $temp_path = storage_path('app/temp') . '/' . $path;

        $file = $temp_path . '/upload.zip';

        // Unzip the file
        $zip = new ZipArchive();

        if (($zip->open($file) !== true) || !$zip->extractTo($temp_path)) {
            throw new \Exception(trans('modules.errors.unzip', ['module' => $alias]));
        }

        $zip->close();

        // Delete zip file
        File::delete($file);

        return $path;
    }

    public static function copyFiles($path, $alias, $new, $old)
    {
        $temp_path = storage_path('app/temp') . '/' . $path;

        if ($alias == 'core') {
            $directories = [
                'vendor/santigarcor/laratrust/src/commands',
            ];

            foreach ($directories as $directory) {
                File::deleteDirectory(base_path($directory));
            }

            // Move all files/folders from temp path
            if (!File::copyDirectory($temp_path, base_path())) {
                throw new \Exception(trans('modules.errors.file_copy', ['module' => $alias]));
            }

            $directories = [
                'vendor/maatwebsite/excel/src/Maatwebsite',
                'vendor/santigarcor/laratrust/src/config',
                'vendor/santigarcor/laratrust/src/Laratrust',
                'vendor/santigarcor/laratrust/src/views',
            ];

            foreach ($directories as $directory) {
                File::deleteDirectory(base_path($directory));
            }
        } else {
            if ($module = Module::findByAlias($alias)) {
                $module_path = $module->getPath();
            } else {
                $module_path = base_path('modules/' . Str::studly($alias));
            }

            // Create module directory
            if (!File::isDirectory($module_path)) {
                File::makeDirectory($module_path);
            }

            // Move all files/folders from temp path
            if (!File::copyDirectory($temp_path, $module_path)) {
                throw new \Exception(trans('modules.errors.file_copy', ['module' => $alias]));
            }
        }

        // Delete temp directory
        File::deleteDirectory($temp_path);

        return $path;
    }

    public static function finish($alias, $new, $old)
    {
        if ($alias == 'core') {
            $companies = [session('company_id')];
        } else {
            $companies = ModuleModel::alias($alias)->where('company_id', '<>', '0')->pluck('company_id')->toArray();
        }

        foreach ($companies as $company) {
            $command = "php artisan update:finish {$alias} {$company} {$new} {$old}";

            \Log::info("Running finish command for {$alias} update...");

            if (true !== $result = Console::run($command, true)) {
                $message = !empty($result) ? $result : "Not able to finalize {$alias} update";

                \Log::info($message);
                throw new \Exception($message);
            }
        }
    }

    public static function all()
    {
        // Get data from cache
        $data = Cache::get('updates');

        if (!empty($data)) {
            return $data;
        }

        // No data in cache, grab them from remote
        $data = array();

        $modules = Module::all();

        $versions = Versions::latest($modules);

        foreach ($versions as $alias => $version) {
            if (empty($version->data)) {
                continue;
            }

            if ($alias == 'core') {
                $installed_version = version('short');
            } else {
                $module = Module::findByAlias($alias);
                $installed_version = $module->get('version');
            }

            if (version_compare($installed_version, $version->data->latest, '>=')) {
                continue;
            }

            $data[$alias] = $version;
        }

        Cache::put('updates', $data, Date::now()->addHour(6));

        return $data;
    }
}
