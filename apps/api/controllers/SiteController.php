<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @return string[]
     */
    public function actionIndex()
    {
        return ['welcome'];
    }
}
