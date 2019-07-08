<?php

declare(strict_types=1);

namespace frontend\controllers;

use frontend\models\PhoneReportForm;
use frontend\models\ReportForm;
use frontend\services\AboutService;
use frontend\services\DataConverterService;
use frontend\services\PhoneReportService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    /**
     * @var DataConverterService $dataConverterService
     */
    private $dataConverterService;

    /**
     * @var AboutService $aboutService
     */
    private $aboutService;

    private $phoneReportService;

    public function __construct(
        string $id,
        Module $module,
        DataConverterService $dataConverterService,
        AboutService $aboutService,
        PhoneReportService $phoneReportService,
        array $config = []
    ) {
        $this->dataConverterService = $dataConverterService;
        $this->aboutService = $aboutService;
        $this->phoneReportService = $phoneReportService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }


    public function actionConvertTime()
    {
        $reportForm = new ReportForm();
        $dataModels = [];

        if ($reportForm->load(Yii::$app->request->post())) {
            $dataModels = $this->dataConverterService->getDataTimeModels($reportForm->text);
            $exporter = $this->dataConverterService->createXlsExporterFromDataModels($dataModels);

            return $exporter->send('time-report.xls');
        }

        return $this->render('time-report', [
            'reportForm' => $reportForm,
            'dataModels' => $dataModels,
        ]);
    }

    public function actionConvertData()
    {
        $reportForm = new ReportForm();
        $dataModels = [];

        if ($reportForm->load(Yii::$app->request->post())) {
            $dataModels = $this->dataConverterService->getDataModels($reportForm->text);
            $exporter = $this->dataConverterService->createXlsExporterFromDataModels($dataModels);

            return $exporter->send('data-report.xls');
        }

        return $this->render('data-report', [
            'reportForm' => $reportForm,
            'dataModels' => $dataModels,
        ]);
    }

    public function actionAbout(): string
    {
        return $this->render('about', [
            'aboutForm' => $this->aboutService->getAboutData(),
        ]);
    }

    public function actionPhoneReport()
    {
        $model = new PhoneReportForm();

        if ($model->load(Yii::$app->request->post())) {
            $reportFilePath = $this->phoneReportService->uploadPhoneReport($model);

            $reportCsv = $this->phoneReportService->createPhoneReportFile($reportFilePath);

            return Yii::$app->response->sendFile($reportCsv);
        }

        return $this->render('phone-report', [
            'model' => $model
        ]);
    }
}
