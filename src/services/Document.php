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
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bulk($data)
    {
        $options = $this->buildRequestOption($data);
        $res = $this->_client->delete("api/_bulk", $options);
        return json_decode($res->getBody(), true);
    }
}
