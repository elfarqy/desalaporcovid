<?php

namespace app\models;

use Yii;
use app\models\table\Kelurahan;

class KelurahanModel extends Kelurahan
{

    public function attributeLabels()
    {
        return [
            'id_kel' => Yii::t('app', 'Kelurahan'),
            'id_kec' => Yii::t('app', 'Kecamatan'),
            'nama' => Yii::t('app', 'Nama'),
        ];
    }

	public function getKelurahanBelongsToKecamatanModel()
	{
		return $this->hasOne(KecamatanModel::className(),['id_kec'=>'id_kec']);
	}

    public function getKelurahanHasManyPoskoModel()
    {
        return $this->hasOne(PoskoModel::className(),['id_kelurahan'=>'id_kel']);
    }

    public static function getKelurahanListByIdKel($id_kel)
    {
        $model = self::find()->where(['id_kel'=>$id_kel])->all();
		$lists = [];
        if ($model)
        {
        	foreach($model as $data)
        	{
				$lists[$data->id_kel] = $data->textKelurahan;
        	}
        }
        return $lists;
    }

    public function getTextKelurahan()
    {
        $id_kel = $this->id_kel;
        $cache = Yii::$app->cache;
        $cacheUniqueId = implode('-', ['getKelurahanText',$id_kel]);
        $getCache = $cache->get($cacheUniqueId);
        if($getCache===FALSE)
        {       
            $model = $this;
            $kelurahan = $model->nama;
            $kecamatan = $model->kelurahanBelongsToKecamatanModel->nama;
            $kabupaten = $model->kelurahanBelongsToKecamatanModel->kecamatanBelongsToKabupatenModel->nama;
            $returnData = implode(' - ', [$kelurahan,$kecamatan,$kabupaten]);
           
            $getCache = $returnData;
            $cache->set($cacheUniqueId,$getCache,60*360);
        }

        $returnData = $getCache;
        return $returnData;
    }

	public static function getTextKelurahanById($id_kel)
	{
        $cache = Yii::$app->cache;
        $cacheUniqueId = implode('-', ['getTextKelurahanById',$id_kel]);
        $getCache = $cache->get($cacheUniqueId);
        if($getCache===FALSE)
        {       
            $model = self::find()->where(['id_kel'=>$id_kel])->one();
            if($model)
            {
                $kelurahan = $model->nama;
                $kecamatan = $model->kelurahanBelongsToKecamatanModel->nama;
                $kabupaten = $model->kelurahanBelongsToKecamatanModel->kecamatanBelongsToKabupatenModel->nama;
                $returnData = implode(' - ', [$kelurahan,$kecamatan,$kabupaten]);
            }
            else
            {
                $returnData = $id_kel;
            }
           
            $getCache = $returnData;
            $cache->set($cacheUniqueId,$getCache,60*360);
        }

        $returnData = $getCache;
        return $returnData;
	}

}