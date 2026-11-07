<?php

namespace Tests\Unit;

use App\Actions\ActionCancel;
use App\Actions\ActionComplete;
use App\Actions\ActionReject;
use App\Actions\ActionRespond;
use App\Actions\ActionStart;
use App\Enums\TaskStatuses;
use App\Exceptions\StatusActionException;
use App\Helpers\DataImporter;
use App\Models\Category;
use App\Service\TaskService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DataImporterTest extends TestCase
{

    public function test_current_status_returns_status_from_constructor(): void
    {

        $data = DataImporter::from('../../database/initialization/categories.csv')->getDataForModel(Category::class);
        $this->assertNotEmpty($data);

    }

}
