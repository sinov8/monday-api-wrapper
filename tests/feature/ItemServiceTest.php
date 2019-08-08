<?php

use Carbon\Carbon;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use sinov8\MondayApiWrapper\models\MondayColumn;
use sinov8\MondayApiWrapper\services\MondayItemService;

class ItemServiceTest extends TestCase
{

    private $mondayItemService;

    protected function setUp(): void
    {
        parent::setUp();

        $dotenv = Dotenv::create("../../");
        $dotenv->load();

        $this->mondayItemService = new MondayItemService(getenv('MONDAY_BASE_URI'), getenv('MONDAY_API_KEY'));
    }

    /**
     * @test
     */
    public function it_creates_an_item_on_the_board()
    {

        $itemId = $this->mondayItemService->createItem("287994487", "new_group82", "Test " . Carbon::now());
        $this->assertNotNull($itemId);

    }

    /**
     * @test
     */
    public function it_updates_an_item()
    {

        $itemId = $this->mondayItemService->createItem("287994487", "new_group82", "Test " . Carbon::now());

        $updatedItemId = $this->mondayItemService->updateItem((int)$itemId, 287994487, [
            new MondayColumn("text8", MondayColumn::TYPE_TEXT, "THE DEMO CO"),
            new MondayColumn("name", MondayColumn::TYPE_TEXT, "DEMO CO"),
            new MondayColumn("activeproperties", MondayColumn::TYPE_NUMERIC, "700"),
            new MondayColumn("lastticketlogged", MondayColumn::TYPE_DATE, Carbon::now())
        ]);

        $this->assertTrue($updatedItemId === $itemId);

    }

}