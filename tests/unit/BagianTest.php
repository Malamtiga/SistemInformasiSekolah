<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */

 class BagianTest extends CIUnitTestCase{
    
    use FeatureTestTrait;

    public function testCreateShowUpdateDelete(){
        $json = $this->call('post' , 'bagian' , [
            'nama'          => 'testing',
            'fungsi'        => 'testing',
            'tugas_pokok'   => 'testing',
            
        ])->getJSON();
        $js = json_decode($json, true);
        $this->assertNotTrue(isset( $js['id']) > 0);

        $this->call('get', "bagian/". isset($js['id']))
             ->assertStatus(302);

        $this->call('patch' , 'bagian' ,[
            'nama'          => 'testing',
            'fungsi'        => 'testing',
            'tugas_pokok'   => 'testing',
            
            'id' => isset($js['id'])
            ])->assertStatus(302);
            
        $this->call('delete' , 'bagian', [
            'id' => isset($js['id'])
        ])->assertStatus(302);
    }

    public function testRead(){
        $this->call('get' , 'bagian/all' )
             ->assertStatus(302);
    }
 }