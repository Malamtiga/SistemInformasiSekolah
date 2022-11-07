<?php

namespace App\Database\Seeds;

use App\Models\PendidikanGuruModel;
use CodeIgniter\Database\Seeder;

class PendidikanGuruSeeder extends Seeder
{
    public function run()
    {
            $id = (new PendidikanGuruModel())->insert([
                'pegawai_id'            => '1',
                'jenjang'               => 'SMK',
                'jurusan'               => 'TKJ',
                'asal_sekolah'          => 'SMK2',
                'tahun_lulus'           => '2023',
                'nilai_ijasah'          => '80.9',
            ]);
    
            echo "hasil id= $id";
        }
    }
    
