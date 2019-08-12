# monday-api-wrapper
A basic package for creating and updating items using the monday.com graphql api: https://monday.com/developers/v2

## Creating an item
```
$mondayItemService = new MondayItemService('MONDAY_BASE_URI, 'MONDAY_API_KEY');
$itemId = $mondayItemService->createItem("boardid", "groupid", "Item Name");
```

## Updating an item
### Creating Columns
```
$columnsArray = [
    new MondayColumn("columnId", "columnType", "newValue");
    new MondayColumn("name", MondayColumn::TYPE_TEXT, "DEMO CO");
    new MondayColumn("activeproperties", MondayColumn::TYPE_NUMERIC, "700");
    new MondayColumn("lastticketlogged", MondayColumn::TYPE_DATE, Carbon::now())
    new MondayColumn("my_checked_col", MondayColumn::TYPE_CHECKBOX, true)
];
```
### Updating item columns
```
$updatedItemId = $this->mondayItemService->updateItem(itemid, boardid, $columnsArray);
```

## GraphQL Queries To Get Input Data
### List columns and groups for a board
```
query {
  boards(ids: 287994487) {
    groups {
      id
      title
      color
      position
    }
    columns{
      id
      title
      type
    }
  }
}
```
