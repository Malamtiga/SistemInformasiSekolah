<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
class SiswaTest extends CIUnitTestCase{

    use FeatureTestTrait;

    public function testLogin(){
        $this->call('post', 'siswa/login', [
            'email' => 'bona@gmail.com',
            'sandi' => '123456'
        ])->assertStatus(404);
    }
    
    public function testCreateShowUpdateDelete(){
        $json = $this->call('post', 'siswa', [
            'nisn'          => '1207354928',
            'nis'           => '27359',
            'status_masuk'  => 'A',
            'thn_masuk'     => '2016',
            'nama_depan'    => 'Ricko',
            'nama_belakang' => 'Marba',
            'nik'           => '6171058538100001',
            'no_kk'         => '6171058374123007',
            'gender'        => 'L',
            'tgl_lahir'     => '1998-09-11',
            'tempat_lahir'  => 'Jakarta Selatan',
            'alamat'        => 'Jl. PSY Gg. NamStyle',
            'kota'          => 'Jakarta Selatan',
            'kelas_id'      => '1',
            'no_telp_rumah' => '082132131231',
            'no_hp_ibu'     => '089364817243',
            'no_hp_ayah'    => '081284759120',
            'nm_ayah'       => 'Johanes',
            'nm_ibu'        => 'Siska',
            'nm_wali'       => 'Rusdi',
            'email'         => 'ricko@gmail.com',
            'sandi'         => 'siswa',
        ])->getJSON();
        $js = json_decode($json, true);

        $this->assertNotTrue(isset( $js['id']) > 0);

        $this->call('get', "siswa/". isset ($js['id']))
            ->assertStatus(302);
        
        $this->call('patch', 'siswa', [
            'nisn'          => '1207354928',
            'nis'           => '27359',
            'status_masuk'  => 'A',
            'thn_masuk'     => '2016',
            'nama_depan'    => 'Ricko',
            'nama_belakang' => 'Marba',
            'nik'           => '6171058538100001',
            'no_kk'         => '6171058374123007',
            'gender'        => 'L',
            'tgl_lahir'     => '1998-09-11',
            'tempat_lahir'  => 'Jakarta Selatan',
            'alamat'        => 'Jl. PSY Gg. NamStyle',
            'kota'          => 'Jakarta Selatan',
            'kelas_id'      => '1',
            'no_telp_rumah' => '082132131231',
            'no_hp_ibu'     => '089364817243',
            'no_hp_ayah'    => '081284759120',
            'nm_ayah'       => 'Johanes',
            'nm_ibu'        => 'Siska',
            'nm_wali'       => 'Rusdi',
            'email'         => 'ricko@gmail.com',
            'sandi'         => 'siswa',
            'id' => isset($js['id'])
        ])->assertStatus(302);

        $this->call('delete', 'siswa', [
            'id' => isset($js['id'])
        ])->assertStatus(302);
    }


    public function testRead(){
        $this->call('get', 'siswa/all')
             ->assertStatus(302);
    }

    public function testLogout(){
        $this->call('delete', 'login')
             ->assertStatus(302);
    }
}