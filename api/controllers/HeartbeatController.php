<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/11/2016
 * Time: 4:28 PM
 */

namespace api\controllers;


use api\components\Utils;
use api\components\Validation;
use api\ApiParams;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use api\models\RecipientMobileLogin;

class HeartbeatController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'heartbeat' => ['post']
                ],
            ]
        ];
    }

    public function beforeAction($event)
    {
        $action = $event->id;
        if (isset($this->actions[$action])) {
            $verbs = $this->actions[$action];
        } elseif (isset($this->actions['*'])) {
            $verbs = $this->actions['*'];
        } else {
            return $event->isValid;
        }
        $verb = Yii::$app->getRequest()->getMethod();
        $allowed = array_map('strtoupper', $verbs);
        if (!in_array($verb, $allowed)) {
            Utils::echoErrorResponse('Method not allowed');
            exit;
        }
        return true;
    }

    public function actionHeartbeat()
    {
        $params = ApiParams::getPostJsonParams();

        $required_params = ['deviceID', 'authKey'];

        $params_to_check = ['authKey'];

        $model = Validation::checkUserParams($params, $required_params, $params_to_check);

        if ($model->errors)
        {
            Utils::echoErrorResponse($model->errors);
        }
        else
        {

        }
    }

}