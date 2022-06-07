<?php

namespace Zinc\services;

use Zinc\exceptions\InvalidParameterException;
use Zinc\Service;

class Search extends Service
{
    protected array $searchType = [
        'matchall',
        'match',
        'matchphrase',
        'term',
        'querystring',
        'prefix',
        'wildcard',
        'fuzzy',
        'daterange'
    ];

    protected array $allowOptions = [
        'search_type',
        'query',
        'sort_fields',
        'from',
        'max_results',
        'aggs',
    ];

    /**
     * 搜索
     * @param $name
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException|InvalidParameterException
     */
    public function search($name, array $options = [])
    {
        $body = [];
        foreach ($options as $optionKey => $option) {
            if (!in_array($optionKey, $this->allowOptions)) {
                throw new InvalidParameterException();
            }
            if ($optionKey === 'search_type' && (!is_string($option) || in_array($option, $this->searchType))) {
                throw new InvalidParameterException();
            }
            $body[$optionKey] = $option;
        }
        if (empty($body)) {
            throw new InvalidParameterException();
        }

        $options = $this->buildRequestOption($body);
        $res = $this->_client->post("api/$name/_search", $options);
        return json_decode($res->getBody(), true);
    }
}
