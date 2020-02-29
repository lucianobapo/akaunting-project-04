<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use App\Utilities\Console;
use App\Utilities\Updater;
use App\Utilities\Versions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Module;

class Updates extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $updates = Updater::all();

        $core = null;
        $expires = null;

        $modules = [];

        if (isset($updates['core'])) {
            $core = $updates['core'];

            if (!empty($core->errors) && !empty($core->errors->expires)) {
                $expires = $core->errors->expires;
                unset($core->errors->expires);
            }
        }

        $rows = Module::all();

        if ($rows) {
            foreach ($rows as $row) {
                $alias = $row->get('alias');

                if (!isset($updates[$alias])) {
                    continue;
                }

                $update = $updates[$alias];

                $m = new \stdClass();
                $m->name = $row->get('name');
                $m->alias = $row->get('alias');
                $m->category = $row->get('category');
                $m->installed = $row->get('version');
                $m->latest = $update->data->latest;
                $m->errors = !empty($update->errors) ? $update->errors->$alias : $update->errors;

                $modules[] = $m;
            }
        }

        $requirements = [];

        $hosting = ' Ask your hosting provider for further help.';

        if (!extension_loaded('bcmath')) {
            $requirements[] = trans('install.requirements.extension', ['extension' => 'BCMath']) . $hosting;
        }

        if (!extension_loaded('ctype')) {
            $requirements[] = trans('install.requirements.extension', ['extension' => 'Ctype']) . $hosting;
        }

        if (!extension_loaded('json')) {
            $requirements[] = trans('install.requirements.extension', ['extension' => 'JSON']) . $hosting;
        }

        return view('install.updates.index', compact('core', 'modules', 'expires', 'requirements'));
    }

    public function changelog()
    {
        return Versions::changelog();
    }

    /**
     * Check for updates.
     *
     * @return Response
     */
    public function check()
    {
        // Clear cache in order to check for updates
        Updater::clear();

        return redirect()->back();
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param  $request
     *
     * @return Response
     */
    public function migrate(Request $request)
    {
        Artisan::call('cache:clear');

        return response()->json([
            'success' => true,
            'errors' => false,
            'data' => [],
        ]);
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param  $request
     *
     * @return Response
     */
    public function finish(Request $request)
    {
        return response()->json([
            'success' => true,
            'errors' => false,
            'redirect' => url("install/updates"),
            'data' => [],
        ]);
    }

    /**
     * Update the core or modules.
     *
     * @param  $alias
     * @param  $version
     * @return Response
     */
    public function update($alias, $version)
    {
        set_time_limit(0); // unlimited

        $core_modules = ['offlinepayment', 'paypalstandard'];

        $modules = Module::all();

        // Delete module files
        foreach ($modules as $module) {
            $alias = $module->getAlias();

            if (in_array($alias, $core_modules)) {
                continue;
            }

            File::deleteDirectory($module->getPath());
        }

        // Update core
        if ($this->applyUpdate('core', '2.0.2') !== true) {
            $message = 'Not able to update core from UI';
            \Log::info($message);

            return redirect('install/updates');
        }

        // Update modules
        foreach ($modules as $module) {
            $alias = $module->get('alias');

            if (in_array($alias, $core_modules)) {
                continue;
            }

            if ($this->applyUpdate($alias, '2.0.0') !== true) {
                $message = 'Not able to update ' . $alias . ' from UI';
                \Log::info($message);

                return redirect('install/updates');
            }
        }

        return redirect('/');
    }

    protected function applyUpdate($alias, $version)
    {
        $company_id = session('company_id');

        $command = "php artisan update {$alias} {$company_id} {$version}";

        if (true !== $result = Console::run($command, true)) {
            $message = !empty($result) ? $result : trans('modules.errors.finish', ['module' => $alias]);

            flash($message)->error();
            \Log::info($message);

            if ($alias == 'core') {
                return false;
            }
        }

        return true;
    }
}
