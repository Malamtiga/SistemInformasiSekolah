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
                <table id='table-kelas' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tingkat</th>
                            <th>Kelas</th>
                            <th>Nama Pegawai</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Kelas</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formKelas" method="post" action="<?=base_url('kelas') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                           
                            <div class="mb-3">
                                <label class="form-label">Tingkat</label>
                                <input type="text" name="tingkat" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <select name="pegawai_id" class="form-control">
                                <?php
                                        use App\Models\PegawaiModel;


                                        $r = (new PegawaiModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['nama_depan']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id" class="form-control">
                                <?php
                                        use App\Models\TahunAjaranModel;


                                        $r = (new TahunAjaranModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['tahun_ajaran']}</option>";
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
        
        
        $('form#formKelas').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
            
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-kelas").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });


        $('button#btn-menambahkan').on('click' , function(){
            $('form#formKelas').submit();

        });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formKelas').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-kelas').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/kelas/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=tingkat]').val(e.tingkat);
                $('input[name=kelas]').val(e.kelas);
                $('input[name=pegawai_id]').val(e.pegawai_id);
                $('input[name=tahun_ajaran_id]').val(e.tahun_ajaran_id);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-kelas').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/kelas`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-kelas').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-kelas').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('kelas/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id',sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                {data: 'tingkat',},
                {data: 'kelas',},
                { data: 'nama_depan', render:(data,type,row,meta)=>{
                    return `${data} `;
                }},
                { data: 'tahun_ajaran', render:(data,type,row,meta)=>{
                    return `${data} `;
                }},
                {data: 'id',
                    render: (data,type,meta,row)=>{
                        var btnEdit     = `<button class='btn btn-light' data-id='${data}'> Edit</button>`;
                        var btnHapus    = `<button class = 'btn btn-danger 'data-id='${data}'> Hapus </button>`;
                        return btnEdit + btnHapus;
                    }

                },
            ]
        });
    });

</script>