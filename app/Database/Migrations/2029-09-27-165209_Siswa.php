<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 10, 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'unique' => true],
            'nisn'                  => ['type' => 'varchar', 'constraint' => 10, 'null' => false],
            'nis'                   => ['type' => 'varchar', 'constraint' => 5, 'null' => false, 'unique' => true],
            'status_masuk'          => ['type' => 'enum("A","P")', 'null' => true],
            'thn_masuk'             => ['type' => 'year', 'constraint' => 4, 'null' => false, 'unique' => true],
            'nama_depan'            => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'nama_belakang'         => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'nik'                   => ['type' => 'varchar', 'constraint' => 16, 'null' => true],
            'no_kk'                 => ['type' => 'varchar', 'constraint' => 16, 'null' => true],
            'gender'                => ['type' => 'enum("L","P")', 'null' => true],
            'tgl_lahir'             => ['type' => 'date', 'null' => true],
            'tempat_lahir'          => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'alamat'                => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'kota'                  => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'kelas_id'              => ['type' => 'int', 'constraint' => 10, 'null' => false, 'unsigned' => true],
            'no_telp_rumah'         => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'no_hp_ibu'             => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'no_hp_ayah'            => ['type' => 'varchar', 'constraint' => 17, 'null' => true],
            'nm_ayah'               => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'nm_ibu'                => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'nm_wali'               => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'foto'                  => ['type' => 'varbinary', 'constraint' => 255, 'null' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'             => ['type' => 'datetime', 'null' => true],
            'deleted_at'             => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('nisn');
        $this->forge->addKey('id_siswa');
        $this->forge->addUniqueKey(['nis', 'thn_masuk']);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'cascade');
        $this->forge->createTable('Siswa');
    }

    public function down()
    {
        $this->forge->dropTable('Siswa');
    }
}
