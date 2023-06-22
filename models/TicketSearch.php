<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ticket;

/**
 * MovieSearch represents the model behind the search form of `app\models\Movie`.
 */
class TicketSearch extends Ticket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'row'], 'integer'],
            [['row_col', 'row',  'created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'phone'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

     

    public function search($params)
    {
        $query = Ticket::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'title'=>$this->title,
            'date'=>$this->date,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'price'=>$this->price,
            'row_col'=>$this->row_col,
            'position'=>$this->position,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
