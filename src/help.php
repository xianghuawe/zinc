<?php

use Zinc\exceptions\MissingParameterException;


if (!function_exists('check_required_parameters')) {
    /**
     * @param array $required
     * @param array $params
     * @return void
     * @throws MissingParameterException
     */
    function check_required_parameters(array $required, array $params): void
    {
        foreach ($required as $req) {
            if (!isset($params[$req])) {
                throw new MissingParameterException(sprintf(
                    'The parameter %s is required',
                    $req
                ));
            }
        }
    }
}


