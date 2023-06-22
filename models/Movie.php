<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movie".
 *
 * @property int $id
 * @property string $name
 * @property string|null $date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property float $price
 * @property string $created_at
 * @property string|null $updated_at
 */

class Movie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    private $available_start;
    public  $reserved_from_to;

    function __construct()
    {

        $range = ['00', '15', '30', '45'];

        for ($h = 8; $h <= 20; $h++) {

            foreach ($range as $m) {
                $current = (($h < 10) ? '0' . $h : $h) . ':' .$m;
                $this->available_start[] = $current;
                if( $h==20 )break;
            }
        }
    }

    public static function tableName()
    {
        return 'movie';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        self::__construct();
        //exit(print_r($this->available_start));

        return [
            [['name', 'price', 'date', 'start_time', 'end_time',], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 200],
            ['date', 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d')],
            ['start_time', 'in', 'range' => array_map(function ($hour) {
                return  $hour;
            }, $this->available_start)],
            ['start_time', 'compare', 'compareAttribute' => 'end_time', 'operator' => '<', 'enableClientValidation' => true],
            ['end_time', 'compare', 'compareAttribute' => 'start_time', 'operator' => '>', 'enableClientValidation' => true]


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    function allUnAvailables()
    {

        $reserved_times = [];

        foreach (Yii::$app->db->createCommand("SELECT * 
        FROM movie")->queryAll() as $movie) {

            extract($movie);

            $this->reserved_from_to[$date][] = $start_time . ' - ' . $end_time;

            $start = strtotime($date . ' ' . $start_time);
            $end = strtotime($date . ' ' . $end_time) + 3600;

            for ($i = $start; $i < $end; $i += 900) {
                $reserved_times[] = date('Y-m-d H:i:s', $i);
            }
        }
        $this->reserved_from_to[$date] = array_unique(
            $this->reserved_from_to[$date]
        );
        sort($this->reserved_from_to[$date]);

        return $reserved_times;
    }
}
