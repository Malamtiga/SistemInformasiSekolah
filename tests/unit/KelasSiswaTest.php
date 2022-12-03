<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */

 class KelasSiswaTest extends CIUnitTestCase{
    
    use FeatureTestTrait;

    public function testCreateShowUpdateDelete(){
        $json = $this->call('post' , 'kelassiswa' , [
            'siswa_id'  => '1',
            'kelas_id'  => '1',
            
        ])->getJSON();
        $js = json_decode($json, true);
        $this->assertNotTrue(isset( $js['id']) > 0);

        $this->call('get', "kelassiswa/". isset($js['id']))
             ->assertStatus(302);

        $this->call('patch' , 'kelassiswa' ,[
            'siswa_id'  => '1',
            'kelas_id'  => '1',
            
            'id' => isset($js['id'])
            ])->assertStatus(302);
            
        $this->call('delete' , 'kelassiswa', [
            'id' => isset($js['id'])
        ])->assertStatus(302);
    }

    public function testRead(){
        $this->call('get' , 'kelassiswa/all' )
             ->assertStatus(302);
    }
 }