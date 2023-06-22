<?php 

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Ticket;
use app\models\User;

class TicketController  extends Controller{
    
    public function actionBuy()
    {
        
        $movie = Yii::$app->db->createCommand('SELECT *, CONCAT(date, " ", start_time) AS start, CONCAT(date, " ", end_time) AS end FROM movie WHERE id='.(int)$_GET["id"]) 
        ->queryOne();
        /**
         * 
         * 
         * 
         * **/
        $model = new \app\models\ReserveForm;

        if (isset($_POST["buttonclicked"]) && $model->load(Yii::$app->request->post()) && $model->collect(Yii::$app->request->post('ReserveForm'))) { 
           //return $this->refresh();
        }
  
        return $this->render('index', ['model'=>$model, 'movie'=> $movie]);
    }

    function actionOrder() {
       
     

        if( !isset($_SESSION['collected'][$_GET['movie_id']]) || count($_SESSION['collected'][$_GET['movie_id']]) == 0 || count($_SESSION['collected'][$_GET['movie_id']]) > 10  ) {
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        
        foreach( $_SESSION['collected'][$_GET['movie_id']] as $ticket ) {
            $ticket = [
                'movie_id' => $_GET['movie_id'],
                'row_col' => $ticket[0],
                'row' => $ticket[1],
                'col' => $ticket[2],
                'name' => $ticket[3],
                'phone' => $ticket[4],
                'email' => $ticket[5],
            ];
            $tickets[] = $ticket;
        }

        Ticket::saveAll($tickets);
        unset($_SESSION['collected'][$_GET['movie_id']]);

        return $this->redirect(['ticket/success']);

    }


    function actionSuccess() {
        return $this->render('success');
    }
}