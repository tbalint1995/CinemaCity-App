<?php

namespace app\controllers\admin;

use app\models\Movie;
use app\models\MovieSearch;
use app\models\Ticket;
use app\models\TicketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * MovieController implements the CRUD actions for Movie model.
 */
class MovieController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'update', 'movies', 'delete', 'create', 'tickets'],
                            'allow' => true,
                            'roles' => ['@'],  
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Movie models.
     *
     * @return string
     */
    public function actionIndex()
    {
       

        $searchModel = new MovieSearch();
        
        $dataProvider = new ActiveDataProvider([
            'query' => Movie::find()->where("date=:date", ['date'=>date('Y-m-d')]),
        ]);;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMovies()
    {
        $searchModel = new MovieSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('movies', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionTickets($id)
    {
        $searchModel = new TicketSearch();
        $connection = Yii::$app->getDb();
        $dataProvider = new ActiveDataProvider([
            'query' => Ticket::find()->where("movie_id=:id", ['id'=>$id]),
      
        ]);;

        return $this->render('tickets', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'movie'=>Movie::findOne($id)
        ]);
    }    

    /**
     * Displays a single Movie model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Movie model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Movie(); 
        if ($this->request->isPost) {

            $data = $this->request->post()["Movie"];

            for( $i = strtotime( $data["date"].' '.$data["start_time"].':00' ); $i < strtotime( $data["date"].' '.$data["end_time"].':00' )+3600; $i += 900 ) {
      
                if( in_array(
                    date('Y-m-d H:i:s', $i), $model->allUnAvailables())  ){
                        $message = 'There is already a movie scheduled at the specified start and/or end time, please choose another!<hr>Reserved times at '.$data["date"].':<br>';

                        foreach( $model->reserved_from_to[$data["date"]] as $time_parts )
                            $message .= '<br/>'.$time_parts.' + (1 hour intermission)';

                            
                        return $this->render('create_error', [
                            'model' => $model,
                            'message' => $message,
                        ]);
                    }
            }

            if( $this->checkIsLastSunday($data["date"], $model )!==false ) {
                return $this->checkIsLastSunday($data["date"], $model );
            }
             

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Movie model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->checkAlreadyOrdered($id);

        $model = $this->findModel($id);
        
        if ($this->request->isPost) {
            
            $data = $this->request->post()["Movie"];
            if( $this->checkIsLastSunday($data["date"], $model )!==false ) {
                return $this->checkIsLastSunday($data["date"], $model );
            }
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
 
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Movie model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->checkAlreadyOrdered($id);

        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the Movie model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Movie the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Movie::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function checkAlreadyOrdered($id){
        Yii::$app->utils->hasReservedSeat($id) and call_user_func(function(){
            http_response_code(403);
            exit;
        });
    }

    private function checkIsLastSunday($day, $model){
        if( Yii::$app->utils->isLastSunday($day) ) {
            $message = 'The day: '.$day.' the last sunday of the month it is not applicable!';
            return $this->render('create_error', [
                'model' => $model,
                'message' => $message,
            ]);
        }
        return false;
    }
}
