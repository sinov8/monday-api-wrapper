<?php

namespace sinov8\MondayApiWrapper\services;

class MondayItemService extends MondayService
{

    public function createItem($boardId, $groupId, $itemName)
    {

        $itemName = json_encode($itemName);

        $requestDataJson = json_encode([
            'query' => "mutation { create_item(board_id: {$boardId}, group_id: {$groupId}, item_name:{$itemName}) { id }}"
        ]);

        $response = $this->client->request('POST', $this->baseUri, [
            'headers' => [
                'Authorization' => 'bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json'
            ],
            'body'    => $requestDataJson
        ]);

        $itemCreateResult = json_decode($response->getBody()->getContents(), true);
        return $itemCreateResult["data"]["create_item"]["id"];

    }

    public function updateItem($itemId, $boardId, $columns)
    {

        $columnValues = [];

        foreach ($columns as $column) {
            $columnValues[$column->getKey()] = $column->getValue();
        }


        $mutation = <<<'MUTATION'
mutation ($itemId: Int!, $boardId: Int!, $columnValues: JSON!) {
  change_multiple_column_values(item_id:$itemId,board_id:$boardId,column_values:$columnValues){
    id
  }
}
MUTATION;

        $variables = ['itemId' => $itemId, 'boardId' => $boardId, 'columnValues' => json_encode($columnValues)];

        $request = json_encode([
            'query'     => $mutation,
            'variables' => $variables,
        ]);

        $response = $this->client->request('POST', $this->baseUri, [
            'headers' => [
                'Authorization' => 'bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json'
            ],
            'body'    => $request,
        ]);

        $itemUpdateResult = json_decode($response->getBody()->getContents(), true);
        return $itemUpdateResult["data"]["change_multiple_column_values"]["id"];

    }

}