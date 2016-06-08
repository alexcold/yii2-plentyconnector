<?php

namespace alexcold\plentyconnector\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use alexcold\plentyconnector\models\SoapSetting;

/**
 * SoapSettingSearch represents the model behind the search form about `app\models\SoapSetting`.
 */
class SoapSettingSearch extends SoapSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'version', 'enabled'], 'integer'],
            [['connection_uri', 'username', 'password'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = SoapSetting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ID' => $this->ID,
            'version' => $this->version,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'connection_uri', $this->connection_uri])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
