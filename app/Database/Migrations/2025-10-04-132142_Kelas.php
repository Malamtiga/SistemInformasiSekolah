<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true, 'null'=> false],
            'tingkat'          => ['type'=>'tinyint', 'constraint'=>3, 'unsigned'=>true, 'null'=>false],
            'kelas'            => ['type'=>'char', 'constraint'=>1,'null'=>true],
            'pegawai_id'       => ['type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'null'=>false],
            'tahun_ajaran_id'  => ['type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'null'=>false],
                      
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('tahun_ajaran_id', 'tahun_ajaran', 'id', 'cascade');
        $this->forge->addForeignKey('pegawai_id', 'pegawai', 'id', 'cascade'); 
        $this->forge->createtable('Kelas');
    }

    public function down()
    {
        $this->forge->droptable('Kelas'); 
    }
}
