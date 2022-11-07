<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PendidikanGuru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true,'null'=>false],
            'pegawai_id'       => ['type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'null'=>false],
            'jenjang'          => ['type'=>'varchar','constraint'=>25,'null'=>false],
            'jurusan'          => ['type'=>'varchar','constraint'=>70,'null'=>true],
            'asal_sekolah'     => ['type'=>'varchar','constraint'=>100,'null'=>true],
            'tahun_lulus'      => ['type'=>'year', 'constraint'=>4, 'null'=>true],
            'nilai_ijasah'     => ['type'=>'double','null'=>true],             
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addforeignKey('pegawai_id', 'pegawai', 'id', 'cascade'); 
        $this->forge->createtable('pendidikan_guru');
    }

    public function down()
    {
        $this->forge->droptable('pendidikan_guru'); 
    }
}

