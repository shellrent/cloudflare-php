<?php

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class RulesLists implements API
{
    use BodyAccessorTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getLists(string $accountId)
    {
        $response = $this->adapter->get('/accounts/' . $accountId . '/rules/lists');
        $this->body = json_decode($response->getBody());

        return (object)['result' => $this->body->result];
    }

    public function getListDetails(string $accountId, string $listId)
    {
        $response = $this->adapter->get('/accounts/' . $accountId . '/rules/lists/' . $listId);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function getListItems(string $accountId, string $listId, string $search = '', int $itemsPerPage = 20, string $cursor = '')
    {

        $options = [
            'per_page' => $itemsPerPage,
        ];

        if ($search) {
            $options['search'] = $search;
        }

        if ($cursor) {
            $options['cursor'] = $cursor;
        }

        $response = $this->adapter->get('/accounts/' . $accountId . '/rules/lists/' . $listId . '/items', $options);
        $this->body = json_decode($response->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function createList(string $accountId, string $kind, string $name, string $description = '')
    {
        $options = [
            'kind' => $kind,
            'name' => $name,
        ];

        if ($description) {
            $options['description'] = $description;
        }

        $response = $this->adapter->post('/accounts/' . $accountId . '/rules/lists', $options);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function createListItem(string $accountId, string $listId, array $ip)
    {
        $options = [];
        foreach ($ip as $ipAddress) {
            $options['ip'] = $ipAddress;
        }

        $response = $this->adapter->post('/accounts/' . $accountId . '/rules/lists/' . $listId . '/items', $options);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function deleteListItem(string $accountId, string $listId, string $item = '')
    {

        $response = $this->adapter->delete('/accounts/' . $accountId . '/rules/lists/' . $listId . '/items' . ($item ? '/' . $item : ''));
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

    public function getOperationStatus(string $accountId, string $operationId)
    {
        $response = $this->adapter->get('/accounts/' . $accountId . '/rules/lists/bulk_operations/' . $operationId);
        $this->body = json_decode($response->getBody());

        return $this->body->result;
    }

}
