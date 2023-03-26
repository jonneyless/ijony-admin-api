<?php

use yii\web\Response;

function parseResponseData(Response $response)
{
    $format = $response->format;

    if (!in_array($format, [Response::FORMAT_JSON, Response::FORMAT_JSONP, Response::FORMAT_XML])) {
        $response->format = Response::FORMAT_JSON;
    }

    $code = $response->getStatusCode();
    if ($code > 300) {
        $response->setStatusCode(200);

        $data['errors'] = $response->data;
    } else {
        $data = $response->data;
    }

    $response->data = [
        'success' => $response->isSuccessful,
        'code' => $code,
        'message' => $response->statusText,
        'data' => $data,
    ];
}