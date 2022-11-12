<?php

namespace App\Database\Seeds;

use App\Models\KelasModel;
use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
            $id = (new KelasModel())->insert([
                'tingkat'             => '1',
                'kelas'               => 'A',
                'pegawai_id'          => '1',
                'tahun_ajaran_id'     => '1',
               
            ]);
       
       
               
            
    
            echo "hasil id= $id";
        }
    }
    