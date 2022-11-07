<?php

namespace App\Controllers;
use Agoenxz21\Datatables\Datatable;
use App\Controllers\BaseController;
use App\Models\TahunAjaranModel;
use CodeIgniter\Exceptions\PageNotFoundException;

use function PHPUnit\Framework\returnSelf;

class TahunAjaranController extends BaseController
{
    
    public function index()
    {
        return view('tahunajaran/table');       
    }
    public function all(){
        $mm = new TahunAjaranModel();
        $mm->select(['id', 'tahun_ajaran', 'tgl_mulai', 'tgl_selesai', 'status_aktif']);
        
        return (new Datatable ($mm))
                ->setFieldFilter(['tahun_ajaran', 'tgl_mulai' , 'tgl_selesai', 'status_aktif'])
                ->draw();
    }
    public function show($id){
        $r = (new TahunAjaranModel())->where('id', $id)->first();
        if ($r == null) throw PageNotFoundException::forPageNotFound();

        return $this->response->setJSON($r);
    }
    public function store(){
        $mm = new TahunAjaranModel();

        $id =  $mm -> insert([
            'tahun_ajaran'       => $this->request->getVar('tahun_ajaran'),
            'tgl_mulai'    => $this->request->getVar('tgl_mulai'),
            'tgl_selesai'  => $this->request->getVar('tgl_selesai'),
            'status_aktif'     => $this->request->getVar('status_aktif'),
        ]);
        return $this->response->setJSON(['id' => $id])
        ->setStatusCode(intval($id)> 0 ? 200 : 406);  
    }
    public function update(){
        $mm = new TahunAjaranModel();
        $id = (int)$this->request->getVar('id');
        
        if($mm->find($id) == null)
        throw PageNotFoundException::forPageNotFound();
        
        $hasil = $mm->update($id,[
            'tahun_ajaran'       => $this->request->getVar('tahun_ajaran'),
            'tgl_mulai'    => $this->request->getVar('tgl_mulai'),
            'tgl_selesai'  => $this->request->getVar('tgl_selesai'),
            'status_aktif'     => $this->request->getVar('status_aktif'),
        ]);
        return $this->response->setJSON(['result'=>$hasil]);
    }
    public function delete(){
        $mm = new TahunAjaranModel();
        $id = $this->request->getVar('id');
        $hasil = $mm->delete($id);
        return $this->response->setJSON(['result' => $hasil]);
    }    
}
