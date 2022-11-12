<?php

namespace App\Controllers;
use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\SiswaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

use function PHPUnit\Framework\returnSelf;

class SiswaController extends BaseController
{
    
    public function index()
    {
        return view('siswa/table');       
    }
    public function all(){
        $sm = SiswaModel::view();
        
        return (new Datatable ($sm))
                ->setFieldFilter([ 'nisn', 'nis', 'status_masuk' ,'thn_masuk', 'nama_depan'])
                ->draw();
    }
    public function show($id){
        $r = (new SiswaModel())->where('id', $id)->first();
        if ($r == null) throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }
    public function store(){
        $sm = new SiswaModel();

        $id =  $sm -> insert([
            'nisn'          => $this->request->getVar('nisn'),
            'nis'           => $this->request->getVar('nis'),
            'status_masuk'  => $this->request->getVar('status_masuk'),
            'thn_masuk'     => $this->request->getVar('thn_masuk'),
            'nama_depan'    => $this->request->getVar('nama_depan'),
            'nama_belakang' => $this->request->getVar('nama_belakang'),
            'nik'           => $this->request->getVar('nik'),
            'no_kk'         => $this->request->getVar('no_kk'),
            'gender'        => $this->request->getVar('gender'),
            'tgl_lahir'     => $this->request->getVar('tgl_lahir'),
            'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
            'alamat'        => $this->request->getVar('alamat'),
            'kota'          => $this->request->getVar('kota'),
            'kelas_id'      => $this->request->getVar('kelas_id'),
            'no_telp_rumah' => $this->request->getVar('no_telp_rumah'),
            'no_hp_ibu'     => $this->request->getVar('no_hp_ibu'),
            'no_hp_ayah'    => $this->request->getVar('no_hp_ayah'),
            'nm_ayah'       => $this->request->getVar('nm_ayah'),
            'nm_ibu'        => $this->request->getVar('nm_ibu'),
            'nm_wali'       => $this->request->getVar('nm_wali'),
        ]);
        return $this->response->setJSON(['id' => $id])
        ->setStatusCode(intval($id)> 0 ? 200 : 406);  
    }
    public function update(){
        $sm = new SiswaModel();
        $id = (int)$this->request->getVar('id');
        
        if($sm->find($id) == null)
        throw PageNotFoundException::forPageNotFound();
        
        $hasil = $sm->update($id,[
            'nisn'          => $this->request->getVar('nisn'),
            'nis'           => $this->request->getVar('nis'),
            'status_masuk'  => $this->request->getVar('status_masuk'),
            'thn_masuk'     => $this->request->getVar('thn_masuk'),
            'nama_depan'    => $this->request->getVar('nama_depan'),
            'nama_belakang' => $this->request->getVar('nama_belakang'),
            'nik'           => $this->request->getVar('nik'),
            'no_kk'         => $this->request->getVar('no_kk'),
            'gender'        => $this->request->getVar('gender'),
            'tgl_lahir'     => $this->request->getVar('tgl_lahir'),
            'tempat_lahir'  => $this->request->getVar('tempat_lahir'),
            'alamat'        => $this->request->getVar('alamat'),
            'kota'          => $this->request->getVar('kota'),
            'kelas_id'      => $this->request->getVar('kelas_id'),
            'no_telp_rumah' => $this->request->getVar('no_telp_rumah'),
            'no_hp_ibu'     => $this->request->getVar('no_hp_ibu'),
            'no_hp_ayah'    => $this->request->getVar('no_hp_ayah'),
            'nm_ayah'       => $this->request->getVar('nm_ayah'),
            'nm_ibu'        => $this->request->getVar('nm_ibu'),
            'nm_wali'       => $this->request->getVar('nm_wali'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }
    public function delete(){
        $sm = new SiswaModel();
        $id = $this->request->getVar('id');
        $hasil = $sm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }    
}
