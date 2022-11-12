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

                <form method="POST" action="<?=base_url('login')?>">
                    <input type="hidden" name="_method" value="delete" />
                    <button class="btn btn-sm btn-danger">Logout</button>
                </form>
     
                <button class="float-end btn btn-sm btn-primary" id="btn-tambah">Tambah</button>
                <table id='table-pegawai' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nip</th>
                            <th>Nama</th>
                            <th>Gelar</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Bagian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Pegawai</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formPegawai" method="post" action="<?=base_url('pegawai') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">Nip</label>
                                <input type="text" name="nip" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Depan</label>
                                <input type="text" name="nama_depan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Belakang</label>
                                <input type="text" name="nama_belakang" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gelar Depan</label>
                                <input type="text" name="gelar_depan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gelar Belakang</label>
                                <input type="text" name="gelar_belakang" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="L">Laki - Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Telp</label>
                                <input type="text" name="no_telp" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No WA</label>
                                <input type="text" name="no_wa" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bagian</label>
                                <select name="bagian_id" class="form-control">
                                <?php
                                        use App\Models\BagianModel;


                                        $r = (new BagianModel())->findAll();
                                        
                                        foreach($r as $k){
                                            echo "<option value='{$k['id']}'>{$k['nama']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text" name="kota" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sandi</label>
                                <input type="text" name="sandi" class="form-control">
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
        
        
        $('form#formPegawai').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
            
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-pegawai").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });


        $('button#btn-menambahkan').on('click' , function(){
            $('form#formPegawai').submit();

        });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formPegawai').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-pegawai').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/pegawai/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=nip]').val(e.nip);
                $('input[name=nama_depan]').val(e.nama_depan);
                $('input[name=nama_belakang]').val(e.nama_belakang);
                $('input[name=gelar_depan]').val(e.gelar_depan);
                $('input[name=gelar_belakang]').val(e.gelar_belakang);
                $('input[name=gender]').val(e.gender);
                $('input[name=no_telp]').val(e.no_telp);
                $('input[name=no_wa]').val(e.no_wa);
                $('input[name=email]').val(e.email);
                $('input[name=bagian_id]').val(e.bagian_id);
                $('input[name=alamat]').val(e.alamat);
                $('input[name=kota]').val(e.kota);
                $('input[name=tgl_lahir]').val(e.tgl_lahir);
                $('input[name=tempat_lahir]').val(e.tempat_lahir);
                $('input[name=sandi]').val(e.sandi);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-pegawai').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/pegawai`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-pegawai').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-pegawai').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('pegawai/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id',sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                {data: 'nip',},
                { data: 'nama_depan', render:(data,type,row,meta)=>{
                    return `${data} ${row['nama_belakang']}`;
                }},
                {data: 'gelar_depan',},
                {data: 'gender',
                    render: (data,type,row,meta)=>{
                        if(data === 'L'){
                            return 'Laki - Laki';
                        }
                        else if(data === 'P'){
                            return 'Perempuan';
                        }
                        return data;
                    }
                },
                {data: 'email',},
                
                { data: 'nama', render:(data,type,row,meta)=>{
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