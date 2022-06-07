<?php

namespace Zinc;

use GuzzleHttp\Client;
use Pimple\Container;
use Zinc\providers\Document;
use Zinc\providers\Index;
use Zinc\providers\Search;

/**
 * @property  services\Index $index
 * @property  services\Document $document
 * @property  services\Search $search
 */
class Application extends Container
{
    protected array $_required_config = [
        'zinc_uri',
        'auth'
    ];

    protected array $providers = [
        Index::class,
        Document::class,
        Search::class,
    ];

    /**
     * @param array $config
     * @param array $values
     * @throws exceptions\MissingParameterException
     */
    public function __construct(array $config, array $values = [])
    {
        parent::__construct($values);
        check_required_parameters($this->_required_config, $config);
        $this['client'] = new Client([
            'base_uri' => $config['zinc_uri'],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
        $this['auth'] = $config['auth'];

        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this[$name];
    }

}
