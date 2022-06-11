<?php

namespace Zinc\services;

use Zinc\exceptions\InvalidParameterException;
use Zinc\Service;

class Index extends Service
{
    private array $validAttributes = ['mapping', 'settings'];

    /**
     * 检查属性字段是否合法
     * @param string $attributeName
     * @return void
     * @throws InvalidParameterException
     */
    protected function checkAttributeIsValid(string $attributeName)
    {
        if (!in_array($attributeName, $this->validAttributes)) {
            throw new InvalidParameterException();
        }
    }

    /**
     * 创建
     * @param string $name
     * @param array $properties
     * @param string $storageType
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $name, array $properties, string $storageType = 'disk')
    {
        $options = $this->buildRequestOption([
            "name" => $name,
            "storage_type" => $storageType,
            "mappings" => [
                "properties" => $properties
            ]
        ]);
        $res = $this->_client->post('api/index', $options);
        return json_decode($res->getBody(), true);
    }

    /**
     * 查询列表
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list()
    {
        $res = $this->_client->get('api/index', $this->buildRequestOption());
        return json_decode($res->getBody(), true);
    }

    /**
     * 删除
     * @param string $name
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $name)
    {
        $res = $this->_client->delete('api/index/' . $name, $this->buildRequestOption());
        return json_decode($res->getBody(), true);
    }

    /**
     * 更新
     * @param string $name
     * @param $updateField
     * @param array $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidParameterException
     */
    protected function update(string $name, $updateField, array $data)
    {
        $this->checkAttributeIsValid($updateField);
        $res = $this->_client->put("api/$name/_$updateField", $this->buildRequestOption($data));
        return json_decode($res->getBody(), true);
    }

    /**
     * 更新字段配置
     * @param string $name
     * @param array $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidParameterException
     */
    public function updateMapping(string $name, array $data)
    {
        return $this->update($name, 'mapping', $data);
    }

    /**
     * 查询配置
     * @param string $name
     * @param string $attributeName
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidParameterException
     */
    public function getAttribute(string $name, string $attributeName)
    {
        $this->checkAttributeIsValid($attributeName);
        $res = $this->_client->get("api/$name/_$attributeName", $this->buildRequestOption());
        return json_decode($res->getBody(), true);
    }

    /**
     * 查询字段配置
     * @param string $name
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidParameterException
     */
    public function getMapping(string $name)
    {
        return $this->getAttribute($name, 'mapping');
    }

    /**
     * 查询设置
     * @param string $name
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidParameterException
     */
    public function getSettings(string $name)
    {
        return $this->getAttribute($name, 'settings');
    }

    /**
     * 更新设置
     * @param string $name
     * @param array $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidParameterException
     */
    public function updateSettings(string $name, array $data)
    {
        return $this->update($name, 'settings', $data);
    }
}
