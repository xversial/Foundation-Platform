<?php

/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform
 * @version    6.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckForUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:check-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks platform extensions for updates.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $rows = $this->getRows()) {
            return;
        }

        $this->table($this->getHeaders(), $rows);
    }

    /**
     * Returns the table headers.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [ 'Name', 'Slug', 'Version', 'Has Update?', 'Installed?', 'Enabled?' ];
    }

    /**
     * Returns the table rows.
     *
     * @return array
     */
    protected function getRows()
    {
        $yes = "\xe2\x9c\x85";

        $no = "\xe2\x9d\x8c";

        $extensions = $this->laravel['extensions.bag']->filter(function($extension) {
            return $extension->hasUpdate();
        });

        if ($extensions->count() > 0) {
            $this->info('The following updates are available. Run `php artisan platform:upgrade` to update them'. "\n");
        } else {
            return;
        }

        return $extensions->map(function ($extension) use ($yes, $no) {
            $isInstalled = $extension->isInstalled();

            $version = $isInstalled ? 'getInstalledVersion' : 'getVersion';

            return [
                $extension->name,
                $extension->slug,
                $extension->{$version}(),
                $extension->hasUpdate() ? $extension->version : '-',
                $isInstalled ? $yes : $no,
                $extension->isEnabled() ? $yes : $no,
            ];
        });
    }
}
