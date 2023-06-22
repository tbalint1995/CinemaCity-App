<?php 
namespace app\models;

use Yii;

class Ticket extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ticket';
    }

    public function rules()
    {
        return [
            [['movie_id', 'row_col', 'row', 'col', 'name', 'phone', 'email'], 'required'],
            [['movie_id', 'row'], 'integer'],
            [['row_col'], 'string', 'max' => 2],
            [['col'], 'string', 'max' => 1],
            [['name', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => 'Vetítés',
            'row_col' => 'Sor/oszlop száma',
            'row' => 'Sor száma',
            'col' => 'Oszlop száma',
            'Nev' => 'Név',
            'Telefonszam' => 'Telefonszám',
            'Email' => 'Email',
            'created_at' => 'Létrehozva',
            'updated_at' => 'Frissítve',
        ];
    }

    public static function saveAll($tickets)
    {
        foreach ($tickets as $ticket) {
            $model = new Ticket();
            $model->movie_id = $ticket['movie_id'];
            $model->row_col = $ticket['row_col'];
            $model->row = $ticket['row'];
            $model->col = $ticket['col'];
            $model->name = $ticket['name'];
            $model->phone = $ticket['phone'];
            $model->email = $ticket['email'];
            $model->save();
        }
    }
}