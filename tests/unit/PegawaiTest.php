<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
class PegawaiTest extends CIUnitTestCase{

    use FeatureTestTrait;

    public function testLogin(){
        $this->call('post', 'login', [
            'email' => 'bona@gmail.com',
            'sandi' => '123456'
        ])->assertStatus(404);
    }
    
    public function testCreateShowUpdateDelete(){
        $json = $this->call('post', 'pegawai', [
            'nip'                   => '12345',
            'nama_depan'            => 'Bona',
            'nama_belakang'         => 'Ventura',
            'gelar_depan'           => 'S.H',
            'gelar_belakang'        => 'S',
            'gender'                => 'L',
            'no_telp'               => '0831231',
            'no_wa'                 => '07831231',
            'email'                 => 'vbona2016@gmail.com',
            'bagian_id'             => '3',
            'alamat'                => 'Pontianak',
            'kota'                  => 'Pontianak',
            'tgl_lahir'             => '2003-03-03',
            'tempat_lahir'          => 'Pontianak',
            'sandi'                 => '123456',
        ])->getJSON();
        $js = json_decode($json, true);

        $this->assertNotTrue(isset( $js['id']) > 0);

        $this->call('get', "pegawai/". isset ($js['id']))
            ->assertStatus(302);
        
        $this->call('patch', 'pegawai', [
            'nip'                   => '12345',
            'nama_depan'            => 'Bona',
            'nama_belakang'         => 'Ventura',
            'gelar_depan'           => 'S.H',
            'gelar_belakang'        => 'S',
            'gender'                => 'L',
            'no_telp'               => '0831231',
            'no_wa'                 => '07831231',
            'email'                 => 'vbona2016@gmail.com',
            'bagian_id'             => '3',
            'alamat'                => 'Pontianak',
            'kota'                  => 'Pontianak',
            'tgl_lahir'             => '2003-03-03',
            'tempat_lahir'          => 'Pontianak',
            'sandi'                 => '123456',
            'id' => isset($js['id'])
        ])->assertStatus(302);

        $this->call('delete', 'pegawai', [
            'id' => isset($js['id'])
        ])->assertStatus(302);
    }


    public function testRead(){
        $this->call('get', 'pegawai/all')
             ->assertStatus(302);
    }

    public function testLogout(){
        $this->call('delete', 'login')
             ->assertStatus(302);
    }
}