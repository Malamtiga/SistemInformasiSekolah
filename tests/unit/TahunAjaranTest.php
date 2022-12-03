<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */

 class TahunAjaranTest extends CIUnitTestCase{
    
    use FeatureTestTrait;

    public function testCreateShowUpdateDelete(){
        $json = $this->call('post' , 'tahunajaran' , [
            'tahun_ajaran'       => '2022',
            'tgl_mulai'          => '2003-03-03',
            'tgl_selesai'        => '2003-03-03',
            'status_aktif'       => 'Y',
        ])->getJSON();
        $js = json_decode($json, true);
        $this->assertNotTrue(isset( $js['id']) > 0);

        $this->call('get', "tahunajaran/". isset($js['id']))
             ->assertStatus(302);

        $this->call('patch' , 'tahunajaran' ,[
            'tahun_ajaran'       => '2022',
            'tgl_mulai'          => '2003-03-03',
            'tgl_selesai'        => '2003-03-03',
            'status_aktif'       => 'Y',
            
            'id' => isset($js['id'])
            ])->assertStatus(302);
            
        $this->call('delete' , 'tahunajaran', [
            'id' => isset($js['id'])
        ])->assertStatus(302);
    }

    public function testRead(){
        $this->call('get' , 'tahunajaran/all' )
             ->assertStatus(302);
    }
 }