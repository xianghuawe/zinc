<?php

namespace Zinc\services;

use Zinc\Service;

/**
 * todo 文档
 */
class Document extends Service
{
    /**
     * 创建
     * @param $index
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($index, $data)
    {
        $options = $this->buildRequestOption($data);
        $res = $this->_client->post("api/$index/_doc", $options);
        return json_decode($res->getBody(), true);
    }

    /**
     * 删除
     * @param $index
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($index, $id)
    {
        $options = $this->buildRequestOption();
        $res = $this->_client->delete("api/$index/_doc/$id", $options);
        return json_decode($res->getBody(), true);
    }

    /**
     * 更新
     * @param $index
     * @param $id
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($index, $id, $data)
    {
        $options = $this->buildRequestOption($data);
        $res = $this->_client->delete("api/$index/_doc/$id", $options);
        return json_decode($res->getBody(), true);
    }

    /**
     * 批量操作
     * 示例数据 (通过换行符分割 ndjson格式数据 一行操作 一行data)
     * { "create" : { "_index" : "olympics" } }
     * {"Year": 1896, "City": "Athens", "Sport": "Aquatics"}
     *
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bulk($data)
    {
        $options = $this->buildRequestOption($data);
        $options['headers']['Content-Type'] = 'application/x-ndjson';
        $res = $this->_client->post("api/_bulk", $options);
        return json_decode($res->getBody(), true);
    }
}
