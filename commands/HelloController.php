<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use src\database\DataImporterCSV;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionLoadCities(): void
    {
        $dataImporter = new DataImporterCSV('src/database/cities.csv', ['name','lat','lng'], 'cities');
        $dataImporter->import();
    }

    public function actionLoadCategories(): void
    {
        $dataImporter = new DataImporterCSV('src/database/categories.csv', ['name','icon'], 'categories');
        $dataImporter->import();
    }
}
