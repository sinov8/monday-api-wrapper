<?php

namespace sinov8\MondayApiWrapper\services;

class MondayItemService extends MondayService
{

    public function createItem($boardId, $groupId, $itemName)
    {

        $createItemMutation = <<<'CREATE_MUTATION'
mutation($boardId: Int!, $groupId: String!, $itemName: String!) {
  create_item(board_id:$boardId,group_id:$groupId,item_name:$itemName){
    id
  }
}
CREATE_MUTATION;

        $response = $this->makeRequest($createItemMutation, [
            'boardId'  => $boardId,
            'groupId'  => $groupId,
            'itemName' => $itemName
        ]);

        return $response["data"]["create_item"]["id"];

    }

    public function updateItem($itemId, $boardId, $columns)
    {

        $columnValues = [];

        foreach ($columns as $column) {
            $columnValues[$column->getKey()] = $column->getValue();
        }

        $mutation = <<<'UPDATE_MUTATION'
mutation ($itemId: Int!, $boardId: Int!, $columnValues: JSON!) {
  change_multiple_column_values(item_id:$itemId,board_id:$boardId,column_values:$columnValues){
    id
  }
}
UPDATE_MUTATION;

        $response = $this->makeRequest($mutation, [
            'itemId'       => $itemId,
            'boardId'      => $boardId,
            'columnValues' => json_encode($columnValues)
        ]);

        return $response["data"]["change_multiple_column_values"]["id"];

    }

}