<?php

namespace Endpoints;

use TestCase;

class RulesListsTest extends TestCase
{

    public function testCreateRulesList()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createRulesList.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists'),
                $this->equalTo([
                    'kind' => 'ip',
                    'name' => 'ip-allowlist',
                ])
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->createList('01a7362d577a6c3019a474fd6f485823', 'ip', 'ip-allowlist');

        $this->assertEquals('2c0fc9fa937b11eaa1b71c4d701ab86e', $result->id);
        $this->assertEquals('ip', $result->kind);
        $this->assertEquals('ip-allowlist', $result->name);

        $this->assertEquals('2c0fc9fa937b11eaa1b71c4d701ab86e', $rulesLists->getBody()->result->id);
    }

    public function testDeleteRulesList()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteRulesList.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists/2c0fc9fa937b11eaa1b71c4d701ab86e')
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->deleteList('01a7362d577a6c3019a474fd6f485823', '2c0fc9fa937b11eaa1b71c4d701ab86e');

        $this->assertEquals(true, $result->success);
        $this->assertEquals(true, $rulesLists->getBody()->success);
    }

    public function testGetRulesLists()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listRulesLists.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists')
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->getLists('01a7362d577a6c3019a474fd6f485823');

        $this->assertEquals('2c0fc9fa937b11eaa1b71c4d701ab86e', $result[0]->id);
        $this->assertEquals('2c0fc9fa937b11eaa1b71c4d701ab86e', $rulesLists->getBody()->result[0]->id);
    }

    public function testGetRulesListDetails()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getRulesListDetails.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists/2c0fc9fa937b11eaa1b71c4d701ab86e')
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->getListDetails('01a7362d577a6c3019a474fd6f485823', '2c0fc9fa937b11eaa1b71c4d701ab86e');

        $this->assertEquals('2c0fc9fa937b11eaa1b71c4d701ab86e', $result->id);
        $this->assertEquals('ip', $result->kind);

        $this->assertEquals('2c0fc9fa937b11eaa1b71c4d701ab86e', $rulesLists->getBody()->result->id);
    }

    public function testGetRulesListItems()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getRulesListItems.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists/2c0fc9fa937b11eaa1b71c4d701ab86e/items'),
                $this->equalTo([
                    'per_page' => 20,
                ])
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->getListItems('01a7362d577a6c3019a474fd6f485823', '2c0fc9fa937b11eaa1b71c4d701ab86e');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('10.0.0.1', $result->result[0]);
        $this->assertEquals('10.0.0.1', $rulesLists->getBody()->result[0]);
    }

    public function testCreateRulesListItem() {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createRulesListItem.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists/2c0fc9fa937b11eaa1b71c4d701ab86e/items')
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->createListItem('01a7362d577a6c3019a474fd6f485823', '2c0fc9fa937b11eaa1b71c4d701ab86e', [
            '10.0.0.1'
        ]);

        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $result->operation_id);
        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $rulesLists->getBody()->result->operation_id);
    }

    public function testDeleteRulesListItem() {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteRulesListItem.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('delete')->willReturn($response);

        $mock->expects($this->once())
            ->method('delete')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists/2c0fc9fa937b11eaa1b71c4d701ab86e/items')
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->deleteListItem('01a7362d577a6c3019a474fd6f485823', '2c0fc9fa937b11eaa1b71c4d701ab86e', ['6as9450mma215q6so7p79dd981r4ee09']);

        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $result->operation_id);
        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $rulesLists->getBody()->result->operation_id);
    }

    public function testGetOperationStatus() {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOperationStatus.json');

        $mock = $this->getMockBuilder(\Cloudflare\API\Adapter\Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts/01a7362d577a6c3019a474fd6f485823/rules/lists/bulk_operations/4da8780eeb215e6cb7f48dd981c4ea02')
            );

        $rulesLists = new \Cloudflare\API\Endpoints\RulesLists($mock);
        $result = $rulesLists->getOperationStatus('01a7362d577a6c3019a474fd6f485823', '4da8780eeb215e6cb7f48dd981c4ea02');

        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $result->id);
        $this->assertEquals('4da8780eeb215e6cb7f48dd981c4ea02', $rulesLists->getBody()->result->id);
    }

}