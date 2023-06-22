<?php



namespace app\models;
use Yii;
use yii\web\Session;

$session = new Session();
$session->open();

class ReserveForm extends \yii\base\Model
{
    public $position, $movie_id, $name, $phone, $email, $row_col, $row, $col;

    public function rules()
    {
        return [
            [['movie_id', 'position', 'row_col', 'row', 'col',  'name', 'phone', 'email'], 'required'],
            ['email', 'email']
        ];
    }

    function collect( $post ) {

   

        if( !isset($_SESSION['collected']) )
        $_SESSION['collected']=[];
        //https://www.yiiframework.com/doc/guide/2.0/en/helper-array
        // új elem hozzáadása/törlése a tömbhöz
        $is_existing = $_SESSION['collected'][$post["movie_id"]][$post["position"]] ?? false;
        
        if( !$is_existing   )
            $_SESSION['collected'][$post["movie_id"]][$post["position"]] = [$post["row_col"], $post["row"], $post["col"], $post["name"], $post["phone"], $post["email"]];
        else 
            unset(  $_SESSION['collected'][$post["movie_id"]][$post["position"]]  );    

        // if( !isset($_SESSION['userdata']) )
        //     $_SESSION['userdata']=[];    
 
        // $_SESSION['userdata'][$post["movie_id"]] = [$post["name"], $post["phone"], $post["email"]];    

        return true;
 }
}