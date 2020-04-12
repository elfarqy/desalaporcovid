<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= \app\models\PoskoModel::getTotalDesaJoined();?></h3>

              <p>Desa Bergabung</p>
            </div>
            <div class="icon">
              <i class="fa fa-home"></i>
            </div>
            <a href="<?= \yii\helpers\Url::toRoute(['/site/desa']) ;?>" class="small-box-footer">
              Detail <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= \app\models\PoskoModel::getPoskoCount();?></h3>

              <p>Posko Tersedia</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?= \yii\helpers\Url::toRoute(['/site/posko']) ;?>" class="small-box-footer">
              Detail <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= \app\models\User::getPenggunaCount();?></h3>

              <p>Pengguna Bergabung</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="<?= \yii\helpers\Url::toRoute(['/site/signup']);?>" class="small-box-footer">
              Daftar Sekarang <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= \app\models\DataPoskoModel::getDataPoskoCount();?></h3>

              <p>Total Pemudik</p>
            </div>
            <div class="icon">
              <i class="fa fa-automobile"></i>
            </div>
            <a href="<?= \yii\helpers\Url::toRoute(['/laporan/create']);?>" class="small-box-footer">
              Laporkan Warga <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>