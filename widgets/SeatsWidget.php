<?php 
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;

class SeatsWidget extends Widget
{
    public $grid, $movie_id, $disabled;
    private $output='', $empty=[1,2,3,4,  11,12,13,14,  15,16,17,18,  25,26,27,28] ;
    
    static $colnum_to_letter = [
        1 => 'A',
        2 => 'B',
        3 => 'C',
        4 => 'D',
        5 => 'E',
        6 => 'F',
        7 => 'G',
        8 => 'H',
        9 => 'I',
        10 => 'J',
        11 => 'K',
        12 => 'L',
        13 => 'M',
        14 => 'N',
    ];

    public function init()
    {
        parent::init();
        if ( false ) {
            $this->output = 'Error';
        }
    }

    public function run()
    {
        $titles = str_split('ABCDEFGHIJKLMN');
        array_unshift($titles,"");
      
        $colnum = $displaycolnum = 1;
        
      

        $this->output.='<div class="seat-container">'."\n";
            $this->output.="\t".'<div>'."\n";
                
                foreach( $titles as $letter ) {

                    $this->output.="\t\t".'<div class="d-flex justify-content-center align-items-center border-bottom '.((!$letter)? 'border-end':'').'  border-secondary">'."\n";
                         $this->output.="\t\t\t".$letter."\n";
                    $this->output.="\t\t".'</div>'."\n";    
                }    
                
            $this->output.="\t".'</div>'."\n";
        $this->output.='</div>'."\n\n";

        $this->output.='<div class="seat-container">'."\n";
        for( $rows = 1; $rows <= $this->grid['rows']; $rows++ ){
            $this->output.="\t".'<div>'."\n";

            $this->output.="\t\t".'<div class="d-flex justify-content-center align-items-center border-end  border-secondary">'."\n";
                $this->output.=$rows;
            $this->output.="\t\t".'</div>'."\n";

                for( $cols = 1; $cols <= $this->grid['cols']; $cols++ ){

                    $this->output.="\t\t".'<div>'."\n";

                    if( !in_array($colnum , $this->empty) ){

                        $session_item = $_SESSION["collected"][ $this->movie_id ][$displaycolnum] ?? false;

                        $reserved = $session_item!==false;
                    
                        $row_col = "$rows".self::$colnum_to_letter[$cols];

                        $is_ordered = Yii::$app->utils->orderedSeat($this->movie_id, $row_col);

                        $class_infix = 'light';
                        if( $reserved ){
                            $class_infix = 'success';
                        }elseif(  $is_ordered ){ 
                            $class_infix = 'danger';
                        }

                        $this->output.="\t\t\t".Html::submitInput($displaycolnum, ['class' => 'btn btn-'.$class_infix.' border border-secondary reserve-btn', 'data-position'=>$displaycolnum, 'data-row_col'=>$row_col, 
                        'data-row'=>"$rows", 'data-col'=>self::$colnum_to_letter[$cols],
                        'name'=>'buttonclicked', 'disabled'=> ($is_ordered or $this->disabled) ])."\n";
                        $displaycolnum++;
                    
                    }

                    $this->output.="\t\t".'</div>'."\n";
                    $colnum++;
                }    
            $this->output.="\t".'</div>'."\n";
        }
        $this->output.='</div>'."\n"."\n";
        return $this->output ;
    }
}