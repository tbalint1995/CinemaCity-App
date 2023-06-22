<?php 

namespace app\helpers;

use Yii;

class utils{
    function realistic_datetime($unformatted, $from, $to){
        $tt = strtotime($unformatted);
        return date("Y.m.d", $tt ).'<sup>'.date("H:i", $from ).'-'.date("H:i", $to ).'</sup>';
    }

    function getCartCount($movie_id){
        return sizeof($_SESSION['collected'][$movie_id]??[]);
    }

    function getTotal($movie_id, $price){
        $total = $this->getCartCount($movie_id) * $price;   
        return $total;
    }

    function orderedSeatsNumber($movie_id){
        return Yii::$app->db->createCommand('SELECT count(id) 
            AS 
                count 
            FROM 
                ticket 
            WHERE 
                movie_id=:movie_id')
                ->bindValue(':movie_id', $movie_id) 
                ->queryOne()["count"];
    }

    function orderedSeat($movie_id, $row_col){
        
        return Yii::$app->db->createCommand('SELECT count(id) 
            AS 
                count 
            FROM 
                ticket 
            WHERE 
                movie_id=:movie_id 
            AND 
                row_col=:row_col')
                ->bindValue(':movie_id', $movie_id) 
                ->bindValue(':row_col', $row_col) 
                ->queryOne()["count"] > 0;
    }

    function hasReservedSeat($movie_id) {
        return $this->orderedSeatsNumber($movie_id) > 0;
    }


    function getLastSunday() {
        return date("Y-m-d", strtotime("last sunday", mktime(0,0,0,date("n")+1,1)));
     }

     function isLastSunday($y_m_d) {
         return date($y_m_d) == $this->getLastSunday();
     }

}

