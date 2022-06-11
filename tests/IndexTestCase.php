<?php

namespace Zinc\Tests;

use PHPUnit\Framework\TestCase;
use Zinc\Application;

class IndexTestCase extends TestCase
{

    /**
     * @return string
     */
    public function getIndexName()
    {
        return 'IndexTestCase';
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'zinc_uri' => '10.168.30.23:32497',
            'auth' => ['admin', 'admin'],
        ];
    }

    /**
     * @return Application
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function getApp(): Application
    {
        return new Application($this->getConfig());
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function testIndexCreate()
    {
        $app = $this->getApp();
        $indexName = $this->getIndexName();
        $res = $app->index->create($indexName, [
            'id' => [
                "type" => "numeric",
                "index" => true,
                "store" => true,
                "highlightable" => true
            ],
            'name' => [
                "type" => "text",
                "index" => true,
                "store" => true,
                "highlightable" => true
            ],
        ]);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('index', $res);
        $this->assertSame($indexName, $res['index']);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function testIndexList()
    {
        $app = $this->getApp();
        $res = $app->index->list();
        $this->assertIsArray($res);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zinc\exceptions\InvalidParameterException
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function testIndexGetMapping()
    {
        $app = $this->getApp();
        $indexName = $this->getIndexName();
        $res = $app->index->getMapping($indexName);
        $this->assertIsArray($res);
        $this->assertArrayHasKey($indexName, $res);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zinc\exceptions\InvalidParameterException
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function testIndexUpdateMapping()
    {
        $app = $this->getApp();
        $indexName = $this->getIndexName();
        $newMapping = [
            'properties' => [
                'age' => [
                    "type" => "numeric",
                    "index" => true,
                    "store" => true,
                    "highlightable" => true,
                    'sortable' => true,
                ],
            ]
        ];
        $res = $app->index->updateMapping($indexName, $newMapping);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('message', $res);
        $this->assertEquals('ok', $res['message']);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zinc\exceptions\InvalidParameterException
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function testIndexGetSettings()
    {
        $app = $this->getApp();
        $indexName = $this->getIndexName();
        $res = $app->index->getSettings($indexName);
        $this->assertIsArray($res);
        $this->assertArrayHasKey($indexName, $res);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zinc\exceptions\InvalidParameterException
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function testIndexUpdateSettings()
    {
        $app = $this->getApp();
        $indexName = $this->getIndexName() . 'for_update_settings';
        $newMapping = [
            'analysis' => [
                'analyzer' => [
                    "default" => [
                        "type" => "standard"
                    ],
                    'my_analyzer' => [
                        'tokenizer' => 'standard',
                        'char_filter' => [
                            'my_mappings_char_filter'
                        ]
                    ]
                ],
                'char_filter' => [
                    'my_mappings_char_filter' => [
                        'type' => 'mapping',
                        'mappings' => [
                            ":) => _happy_",
                            ":( => _sad_"
                        ]
                    ]
                ]
            ]
        ];
        $res = $app->index->updateSettings($indexName, $newMapping);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('message', $res);
        $this->assertEquals('ok', $res['message']);
        $res = $app->index->delete($indexName);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('index', $res);
        $this->assertSame($indexName, $res['index']);
        $this->assertArrayHasKey('message', $res);
        $this->assertSame('deleted', $res['message']);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zinc\exceptions\MissingParameterException
     */
    public function testIndexDelete()
    {
        $app = $this->getApp();
        $indexName = $this->getIndexName();
        $res = $app->index->delete($indexName);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('index', $res);
        $this->assertSame($indexName, $res['index']);
        $this->assertArrayHasKey('message', $res);
        $this->assertSame('deleted', $res['message']);
    }
}
