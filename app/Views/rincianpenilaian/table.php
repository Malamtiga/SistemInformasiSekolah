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
                
                <table id='table-rincianpenilaian' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penilaian</th>
                            <th>Nama Nilai</th>
                            <th>Nilai Angka</th>
                            <th>Nilai Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Rincian Penilaian</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formRincianPenilaian" method="post" action="<?=base_url('rincianpenilaian') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">Nilai</label>
                                <select name="penilaian_id" class="form-control">
                                <?php
                                        use App\Models\PenilaianModel;


                                        $r = (new PenilaianModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['total_nilai']} - {$k['deskripsi_nilai']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Nilai</label>
                                <input type="text" name="nama_nilai" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Angka</label>
                                <input type="text" name="nilai_angka" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Deskripsi</label>
                                <input type="text" name="nilai_deskripsi" class="form-control">
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
    
    $('form#formRincianPenilaian').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
            
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-rincianpenilaian").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });

        
     $('button#btn-menambahkan').on('click' , function(){
            $('form#formRincianPenilaian').submit();

    });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formRincianPenilaian').trigger('reset');
            $('input[name=_method]').val('');
    });
        $('table#table-rincianpenilaian').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/rincianpenilaian/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=penilaian_id]').val(e.penilaian_id);
                $('input[name=nama_nilai]').val(e.nama_nilai);
                $('input[name=nilai_angka]').val(e.nilai_angka);
                $('input[name=nilai_deskripsi]').val(e.nilai_deskripsi);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
         });

         $('table#table-rincianpenilaian').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/rincianpenilaian`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-rincianpenilaian').DataTable().ajax.reload();
                });
                }
          });

        $('table#table-rincianpenilaian').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('rincianpenilaian/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id',sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                { data: 'deskripsi_nilai', render:(data,type,row,meta)=>{
                    return `${data} `;
                }},
                {data: 'nama_nilai'},
                {data: 'nilai_angka',},
                {data: 'nilai_deskripsi',},
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