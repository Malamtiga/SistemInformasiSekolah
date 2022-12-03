<?=$this->extend('backend/template')?>

<?=$this->section('content')?>

            <div class="container">
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-dark">Table Pendidikan Guru</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <button class="float-end btn btn-sm btn-dark" id="btn-tambah">Tambah Data</button>
                <table id='table-pendidikanguru' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Guru</th>
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
                            <button class="close" data-dismiss="modal">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="formPendidikanguru" method="post" action="<?=base_url('pendidikanguru') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">Nama Guru</label>
                                <select name="pegawai_id" class="form-control">
                                <?php
                                        use App\Models\PegawaiModel;


                                        $r = (new PegawaiModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['nama_depan']} {$k['nama_belakang']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenjang</label>
                                <input type="text" name="jenjang" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" name="asal_sekolah" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Lulus</label>
                                <input type="date" name="tahun_lulus" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Ijasah</label>
                                <input type="text" name="nilai_ijasah" class="form-control">
                            </div>
                           
                        </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btn-menambahkan" >Menambahkan</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>

            <?=$this->endSection()?>


            <?=$this->section('script')?>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js"
            ></script>
            <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"> 
            <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function(){
        $('select[name=pegawai_id]').select2({width:'100%',
            dropdownParent : $('form#formPendidikanguru')
        });
        
        
        
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
                $('input[name=tahun_lulus]').val(e.tahun_lulus);
                $('input[name=nilai_ijasah]').val(e.nilai_ijasah);
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
                    return `${data} ${row['nama_belakang']}`;
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

<?=$this->endSection()?>