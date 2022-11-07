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
                <table id='table-pendidikanguru' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenjang</th>
                            <th>Jurusan</th>
                            <th>Asal Sekolah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Pendidikan Guru</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formPendidikanguru" method="post" action="<?=base_url('pendidikanguru') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
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
                                <label class="form-label">Jenjang</label>
                                <input type="text" name="jenjang" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gelar</label>
                                <input type="text" name="jurusan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" name="asal_sekolah" class="form-control">
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
        
        
        $('form#formPendidikanguru').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
            
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-pendidikanguru").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });


        $('button#btn-menambahkan').on('click' , function(){
            $('form#formPendidikanguru').submit();

        });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formPendidikanguru').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-pendidikanguru').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/pendidikanguru/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=pegawai_id]').val(e.pegawai_id);
                $('input[name=jenjang]').val(e.jenjang);
                $('input[name=jurusan]').val(e.jurusan);
                $('input[name=asal_sekolah]').val(e.asal_sekolah);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-pendidikanguru').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/pendidikanguru`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-pendidikanguru').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-pendidikanguru').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('pendidikanguru/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id',sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                { data: 'nama_depan', render:(data,type,row,meta)=>{
                    return `${data} `;
                }},
                {data: 'jenjang',},
                {data: 'jurusan',},
                {data: 'asal_sekolah',},
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