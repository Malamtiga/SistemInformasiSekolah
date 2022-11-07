<?php

namespace App\Database\Seeds;

use App\Models\TahunAjaranModel;
use CodeIgniter\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run()
    {
        $id = (new TahunAjaranModel())->insert([
            'tahun_ajaran'          => '2022',
            'tgl_mulai'             => '2004-05-19',
            'tgl_selesai'           => '2003-03-15',
            'status_aktif'          => 'Y',
        ]);
        
        $id = (new TahunAjaranModel())->insert([
            'tahun_ajaran'          => '2022',
            'tgl_mulai'             => '2005-05-19',
            'tgl_selesai'           => '2006-03-15',
            'status_aktif'          => 'T',
        ]);

        echo "hasil id= $id";
    }
}
