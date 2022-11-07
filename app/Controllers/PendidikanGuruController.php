<?php

namespace App\Controllers;
use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\KehadiranguruModel;
use App\Models\PendidikanguruModel;
use CodeIgniter\Exceptions\PageNotFoundException;

use function PHPUnit\Framework\returnSelf;

class PendidikanGuruController extends BaseController
{
    
    public function index()
    {
        return view('pendidikanguru/table');       
    }
    public function all(){
        
        $kgm = PendidikanguruModel::view();
      
        
        return (new Datatable ($kgm))
                ->setFieldFilter([ 'nama_depan', 'jenjang', 'jurusan', 'asal_sekolah'])
                ->draw();
    }
    public function show($id){
        $r = (new PendidikanguruModel())->where('id', $id)->first();
        if ($r == null) throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }
    public function store(){
        $kgm = new PendidikanguruModel();

        $id =  $kgm -> insert([
            'pegawai_id'  => $this->request->getVar('pegawai_id'),
            'jenjang'     => $this->request->getVar('jenjang'),
            'jurusan'     => $this->request->getVar('jurusan'),
            'asal_sekolah'=> $this->request->getVar('asal_sekolah'),
        ]);
        return $this->response->setJSON(['id' => $id])
        ->setStatusCode(intval($id)> 0 ? 200 : 406);  
    }
    public function update(){
        $kgm = new PendidikanguruModel();
        $id = (int)$this->request->getVar('id');
        
        if($kgm->find($id) == null)
        throw PageNotFoundException::forPageNotFound();
        
        $hasil = $kgm->update($id,[
            'pegawai_id'  => $this->request->getVar('pegawai_id'),
            'jenjang'     => $this->request->getVar('jenjang'),
            'jurusan'     => $this->request->getVar('jurusan'),
            'asal_sekolah'=> $this->request->getVar('asal_sekolah'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }
    public function delete(){
        $kgm = new PendidikanguruModel();
        $id = $this->request->getVar('id');
        $hasil = $kgm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }    
}
