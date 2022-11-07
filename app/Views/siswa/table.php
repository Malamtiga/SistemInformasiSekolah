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
                
                <table id='table-siswa' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Status Masuk</th>
                            <th>Tahun Masuk</th>
                            <th>Nama Siswa</th>
                            <th>Kelas Sekarang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Siswa</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formSiswa" method="post" action="<?=base_url('siswa') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control">
                            </div>
                            < <div class="mb-3">
                                <label class="form-label">Status Masuk</label>
                                <select name="status_masuk" class="form-control">
                                    <option>STATUS MASUK</option>
                                    <option value="A">Asal</option>
                                    <option value="P">Pindahan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Masuk</label>
                                <input type="date" name="thn_masuk" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <input type="text" name="nama_depan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas Sekarang</label>
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
    
    $('form#formSiswa').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
            
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-siswa").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });

        
     $('button#btn-menambahkan').on('click' , function(){
            $('form#formSiswa').submit();

    });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formSiswa').trigger('reset');
            $('input[name=_method]').val('');
    });
        $('table#table-siswa').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/siswa/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=nisn]').val(e.nisn);
                $('input[name=nis]').val(e.nis);
                $('input[name=status_masuk]').val(e.status_masuk);
                $('input[name=thn_masuk]').val(e.thn_masuk);
                $('input[name=nama_depan]').val(e.nama_depan);
                $('input[name=kelas_id]').val(e.kelas_id);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
         });

         $('table#table-siswa').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/siswa`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-siswa').DataTable().ajax.reload();
                });
                }
          });

        $('table#table-siswa').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('siswa/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id',sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                {data: 'nisn',},
                {data: 'nis'},
                {data: 'status_masuk',
                    render: (data,type,row,meta)=>{
                        if(data === 'A'){
                            return 'Asal';
                        }
                        else if(data === 'P'){
                            return 'Pindahan';
                        }
                        return data;
                    }
                },
                {data: 'thn_masuk',},
                {data: 'nama_depan',},
                {data: 'kelas', render:(data,type,row,meta)=>{
                    return `${data} `;
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