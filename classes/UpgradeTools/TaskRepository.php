<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

namespace PrestaShop\Module\AutoUpgrade\UpgradeTools;

use Exception;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Miscellaneous\CheckFilesVersion;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Miscellaneous\CompareReleases;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Miscellaneous\GetChannelInfo;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Miscellaneous\UpdateConfig;
use PrestaShop\Module\AutoUpgrade\TaskRunner\NullTask;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Rollback\NoRollbackFound;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Rollback\RestoreDb;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Rollback\RestoreFiles;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Rollback\Rollback;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Rollback\RollbackComplete;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\BackupDb;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\BackupFiles;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\CleanDatabase;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\Download;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\Unzip;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\UpgradeComplete;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\UpgradeDb;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\UpgradeFiles;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\UpgradeModules;
use PrestaShop\Module\AutoUpgrade\TaskRunner\Upgrade\UpgradeNow;
use PrestaShop\Module\AutoUpgrade\UpgradeContainer;

class TaskRepository
{
    /**
     * @throws Exception
     */
    public static function get($step, UpgradeContainer $container)
    {
        switch ($step) {
            // MISCELLANEOUS (upgrade configuration, checks etc.)
            case 'checkFilesVersion':
                return new CheckFilesVersion($container);
            case 'compareReleases':
                return new CompareReleases($container);
            case 'getChannelInfo':
                return new GetChannelInfo($container);
            case 'updateConfig':
                return new UpdateConfig($container);

            // ROLLBACK
            case 'noRollbackFound':
                return new NoRollbackFound($container);
            case 'restoreDb':
                return new RestoreDb($container);
            case 'restoreFiles':
                return new RestoreFiles($container);
            case 'rollback':
                return new Rollback($container);
            case 'rollbackComplete':
                return new RollbackComplete($container);

            // UPGRADE
            case 'backupDb':
                return new BackupDb($container);
            case 'backupFiles':
                return new BackupFiles($container);
            case 'cleanDatabase':
                return new CleanDatabase($container);
            case 'download':
                return new Download($container);
            case 'upgradeComplete':
                return new UpgradeComplete($container);
            case 'upgradeDb':
                return new UpgradeDb($container);
            case 'upgradeFiles':
                return new UpgradeFiles($container);
            case 'upgradeModules':
                return new UpgradeModules($container);
            case 'upgradeNow':
                return new UpgradeNow($container);
            case 'unzip':
                return new Unzip($container);
        }
        error_log('Unknown step ' . $step);

        return new NullTask($container);
    }
}
