<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */

 class KelasTest extends CIUnitTestCase{
    
    use FeatureTestTrait;

    public function testCreateShowUpdateDelete(){
        $json = $this->call('post' , 'kelas' , [
                'tingkat'             => '1',
                'kelas'               => 'A',
                'pegawai_id'          => '1',
                'tahun_ajaran_id'     => '1',
        ])->getJSON();
        $js = json_decode($json, true);
        $this->assertNotTrue(isset( $js['id']) > 0);

        $this->call('get', "kelas/". isset($js['id']))
             ->assertStatus(302);

        $this->call('patch' , 'kelas' ,[
            'tingkat'             => '1',
            'kelas'               => 'A',
            'pegawai_id'          => '1',
            'tahun_ajaran_id'     => '1',
            
            'id' => isset($js['id'])
            ])->assertStatus(302);
            
        $this->call('delete' , 'kelas', [
            'id' => isset($js['id'])
        ])->assertStatus(302);
    }

    public function testRead(){
        $this->call('get' , 'kelas/all' )
             ->assertStatus(302);
    }
 }