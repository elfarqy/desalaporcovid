<?php

namespace app\commands;


use app\models\table\JenisLaporan;
use app\models\table\Kabupaten;
use app\models\table\Kecamatan;
use app\models\table\Kelurahan;
use app\models\table\Negara;
use app\models\table\Provinsi;
use app\models\User;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use yii\console\Controller;
use yii\db\Exception;
use yii\helpers\Console;

class ImportController extends Controller
{
    public function actionDependency()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $this->loadAndReadFile(__DIR__ . "/../data/csv/negara.csv", 'Negara', ['id', 'kode_negara', 'nama'],
            Negara::class);
        $this->loadAndReadFile(__DIR__ . "/../data/csv/provinsi.csv", 'Provinsi', ['id_prov', 'nama'], Provinsi::class);
        $this->loadAndReadFile(__DIR__ . "/../data/csv/kabupaten.csv", 'Kabupaten', ['id_kab', 'id_prov', 'nama'],
            Kabupaten::class);
        $this->loadAndReadFile(__DIR__ . "/../data/csv/kecamatan.csv", 'Kecamatan', ['id_kec', 'id_kab', 'nama'],
            Kecamatan::class);
        $this->loadAndReadFile(__DIR__ . "/../data/csv/kelurahan.csv", 'Kelurahan', ['id_kel', 'id_kec', 'nama'],
            Kelurahan::class);
        $this->loadAndReadFile(__DIR__ . "/../data/csv/jenis_laporan.csv", 'Jenis Laporan',
            ['id', 'nama_laporan', 'keterangan', 'status', 'kode'], JenisLaporan::class);

        $roles = [User::LEVEL_POSKO, User::LEVEL_PENGGUNA, User::LEVEL_ADMIN_DESA, User::LEVEL_ADMIN];

        $tmpUser = [];

        $kelurahan = Kelurahan::find()->one();

        foreach ($roles as $role) {
            $tmpUser[] = [
                'username'      => $role . 'teknosuper@gmail.com',
                'authKey'       => null,
                'password'      => md5('12345'),
                'email'         => $role . 'teknosuper@gmail.com',
                'accessToken'   => null,
                'userType'      => $role,
                'user_id'       => null,
                'status'        => User::STATUS_ACTIVE,
                'nama'          => $role . ' Muhammad Athikur Rakhman',
                'kelurahan'     => $kelurahan->id_kel,
                'alamat'        => null,
                'gender'        => User::GENDER_L,
                'tanggal_lahir' => null,
                'tempat_lahir'  => null,
            ];
        }

        \Yii::$app->db->createCommand()->batchInsert(User::tableName(), array_keys(reset($tmpUser)),
            $tmpUser)->execute();

        try {
            $transaction->commit();
        } catch (Exception $exception) {
            $transaction->rollBack();
            Console::stderr('err' . $exception->getMessage());
        }

    }

    protected function loadAndReadFile($filename, $dataType, $keys, $class)
    {

        $loader       = new Csv();
        $spreadSheet  = $loader->load($filename);
        $sheet        = $spreadSheet->getActiveSheet();
        $highestRow   = $sheet->getHighestRow();
        $row          = 2;
        $insertedData = [];
        Console::stdout("Import data {$dataType} \n");
        Console::startProgress($row, $highestRow);
        while (true):
            if (empty($sheet->getCellByColumnAndRow(1, $row)->getValue())) {
                break;
            }
            $tmpVal = [];
            foreach ($keys as $index => $key) {
                $tmpVal[$key] = $sheet->getCellByColumnAndRow(($index + 1), $row)->getValue();
            }
            $insertedData[] = $tmpVal;

            Console::updateProgress($row, $highestRow);
            $row++;
        endwhile;

        Console::endProgress();

        \Yii::$app->db->createCommand()->batchInsert($class::tablename(), $keys, $insertedData)->execute();

    }

}
