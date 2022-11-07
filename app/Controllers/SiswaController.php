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
                ->setFieldFilter([ 'nis', 'nisn', 'status_masuk' ,'thn_masuk', 'nama_depan'])
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
            'nis'          => $this->request->getVar('nis'),
            'nisn'         => $this->request->getVar('nisn'),
            'status_masuk' => $this->request->getVar('status_masuk'),
            'thn_masuk'    => $this->request->getVar('thn_masuk'),
            'nama_depan'   => $this->request->getVar('nama_depan'),
            'kelas_id'     => $this->request->getVar('kelas_id'),
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
            'nis'          => $this->request->getVar('nis'),
            'nisn'         => $this->request->getVar('nisn'),
            'status_masuk' => $this->request->getVar('status_masuk'),
            'thn_masuk'    => $this->request->getVar('thn_masuk'),
            'nama_depan'   => $this->request->getVar('nama_depan'),
            'kelas_id'     => $this->request->getVar('kelas_id'),
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
