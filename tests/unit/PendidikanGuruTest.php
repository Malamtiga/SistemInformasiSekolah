<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */

 class PendidikanGuruTest extends CIUnitTestCase{
    
    use FeatureTestTrait;

    public function testCreateShowUpdateDelete(){
        $json = $this->call('post' , 'pendidikanguru' , [
            'pegawai_id'      => 'testing',
            'jenjang'         => 'testing',
            'jurusan'         => 'testing',
            'asal_sekolah'    => 'testing',
            'tahun_lulus'     => 'testing',
            'nilai_ijasah'    => 'testing',
            
        ])->getJSON();
        $js = json_decode($json, true);
        $this->assertNotTrue(isset( $js['id']) > 0);

        $this->call('get', "pendidikanguru/". isset($js['id']))
             ->assertStatus(302);

        $this->call('patch' , 'pendidikanguru' ,[
            'pegawai_id'      => 'testing',
            'jenjang'         => 'testing',
            'jurusan'         => 'testing',
            'asal_sekolah'    => 'testing',
            'tahun_lulus'     => 'testing',
            'nilai_ijasah'    => 'testing',
            
            'id' => isset($js['id'])
            ])->assertStatus(302);
            
        $this->call('delete' , 'pendidikanguru', [
            'id' => isset($js['id'])
        ])->assertStatus(302);
    }

    public function testRead(){
        $this->call('get' , 'pendidikanguru/all' )
             ->assertStatus(302);
    }
 }