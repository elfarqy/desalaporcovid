<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\form\PoskoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Data Posko');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posko-model-index box box-primary">
    <?php Pjax::begin(); ?>

	  <div class="box box-solid box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title"><i class="fa fa-users"></i> Posko Pemudik Yang Tersedia di Desa Lapor Covid</h3>
	    </div>

	    <div class="box-body table-responsive no-padding">
	        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	        <?= GridView::widget([
	            'dataProvider' => $dataProvider,
	            'filterModel' => $searchModel,
	            'layout' => "{items}\n{summary}\n{pager}",
	            'columns' => [
	                ['class' => 'yii\grid\SerialColumn'],

	                // 'id',
	                'nama_posko',
	                // 'alamat_posko',
	                [
	                    'attribute' => 'id_kelurahan',
	                    'value' => function ($model) {
	                        return ($model->poskoBelongsToKelurahanModel) ? implode(' - ', [$model->poskoBelongsToKelurahanModel->nama,$model->poskoBelongsToKelurahanModel->kelurahanBelongsToKecamatanModel->nama,$model->poskoBelongsToKelurahanModel->kelurahanBelongsToKecamatanModel->kecamatanBelongsToKabupatenModel->nama]) : null;
	                    },
	                    'filter' => Select2::widget([

	                        'model' => $searchModel,

	                        'attribute' => 'id_kelurahan',

	                        // 'data' => Object::typeNames(),

	                        'theme' => Select2::THEME_BOOTSTRAP,

	                        'hideSearch' => true,
	                        'initValueText' => \app\models\KelurahanModel::getTextKelurahanById($searchModel->id_kelurahan),                        
	                        'options' => [

	                            'placeholder' => 'Pilih Kelurahan/Desa ...',

	                        ],
	                        'pluginOptions' => [
	                            'allowClear' => true,
	                            'minimumInputLength' => 4,
	                            'language' => [
	                                'errorLoading' => new JsExpression("function () { return 'Sedang mencari data...'; }"),
	                            ],
	                            'ajax' => [
	                                'url' => \yii\helpers\Url::to(['/site/getdatakelurahan']),
	                                'dataType' => 'json',
	                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
	                            ],
	                        ],

	                    ]),
	                    // 'filterInputOptions' => ['prompt' => 'All Categories', 'class' => 'form-control', 'id' => null]
	                ],
	                // 'email_posko:email',
	                // 'keterangan:ntext',
	 
	            ],
	        ]); ?>
	    </div>
	</div>
    <?php Pjax::end(); ?>
</div>
