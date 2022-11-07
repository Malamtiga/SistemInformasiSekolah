<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet" crosorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js"
            ></script>
            <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"> 
            <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

            <div class="container">
                <button class="float-end btn btn-sm btn-primary" id="btn-tambah">Tambah</button>
                
                <table id='table-jadwal' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Pegawai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Jadwal</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formJadwal" method="post" action="<?=base_url('jadwal') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">Hari</label>
                                <input type="text" name="hari" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-control">
                                    <?php
                                        use App\Models\KelasModel;


                                        $r = (new KelasModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['kelas']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mapel</label>
                                <select name="mapel_id" class="form-control">
                                    <?php
                                        use App\Models\MapelModel;


                                        $r = (new MapelModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['mapel']} - {$k['kelompok']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="text" name="jam_mulai" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="text" name="jam_selesai" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pegawai</label>
                                <select name="pegawai_id" class="form-control">
                                    <?php
                                        use App\Models\PegawaiModel;


                                        $r = (new PegawaiModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['nip']} -  {$k['nama_depan']} - {$k['nama_belakang']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btn-menambahkan" >Menambahkan</button>
                        </div>
                    </div>
                </div>
            </div>
<script>

    $(document).ready(function(){
    
    $('form#formJadwal').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
            
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-jadwal").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });

        
     $('button#btn-menambahkan').on('click' , function(){
            $('form#formJadwal').submit();

    });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formJadwal').trigger('reset');
            $('input[name=_method]').val('');
    });
        $('table#table-jadwal').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/jadwal/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=hari]').val(e.hari);
                $('input[name=kelas_id]').val(e.kelas_id);
                $('input[name=mapel_id]').val(e.mapel_id);
                $('input[name=jam_mulai]').val(e.jam_mulai);
                $('input[name=jam_selesai]').val(e.jam_selesai);
                $('input[name=pegawai_id').val(e.pegawai_id);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
         });

         $('table#table-jadwal').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/jadwal`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-jadwal').DataTable().ajax.reload();
                });
                }
          });

        $('table#table-jadwal').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('jadwal/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id',sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                {data: 'hari',},
                {data: 'kelas', render:(data,type,row,meta)=>{
                    return `${data} `;
                }},
                {data: 'mapel', render:(data,type,row,meta)=>{
                    return `${data}`;
                }},
                {data: 'jam_mulai',},
                {data: 'jam_selesai',},
                {data: 'nama_depan', render:(data,type,row,meta)=>{
                    return `${data} ${row['nama_belakang']}`;
                }},
                {data: 'id',
                    render: (data,type,meta,row)=>{
                        var btnEdit     = `<button class= 'btn-light' data-id='${data}'> Edit</button>`;
                        var btnHapus    = `<button class = 'btn-danger'data-id='${data}'> Hapus </button>`;
                        return btnEdit + btnHapus;
                    }

                },
            ]
        });
    });

</script>