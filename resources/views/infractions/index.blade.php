@extends('admin.main')
@section('content')
<!--CONTENIDO-->
<!-- TABLA -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">Infracciones 
                            <button class="btn btn-primary" onclick="newR()" id="btnNew"><i class="fas fa-file"></i> Nuevo</button> 
                            <a href="" class="btn btn-success"><i class="fas fa-file-csv"></i> CSV</a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <form action="{{ route('infractions.index') }}" method="get">
                                <div class="input-group">
                                    <input type="text" name="texto" value="{{ $texto }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mt-2 table-responsive">
                            <table class="table table-striped table-bordered table-hover table-sm" id="tablaInfractions">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>DNI</th>
                                        <th>Placa</th>
                                        <th>Fecha</th>
                                        <th>Infracción</th>
                                        <th>Descripción</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registros as $reg)
                                        <tr>
                                            <td>{{ $reg->id }}</td>
                                            <td>{{ $reg->dni }}</td>
                                            <td>{{ $reg->plate }}</td>
                                            <td>{{ $reg->fecha }}</td>
                                            <td>{{ $reg->infraccion }}</td>
                                            <td>{{ $reg->description }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm editar" onclick="edit({{ $reg->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm eliminar" onclick="del({{ $reg->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $registros->appends(["texto" => $texto]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN TABLA -->
<!--MODAL UPDATE-->
<div class="modal fade" id="modal-update">
    <div class="modal-dialog modal-lg"></div>
</div>
<!--FIN MODAL UPDATE-->
<!--FIN CONTENIDO-->
@endsection

@push('scripts')
<script>
    function newR() {
        $.ajax({
            method: 'get',
            url: `{{ url('infractions/create') }}`,
            success: function(res) {
                $('#modal-update').find('.modal-dialog').html(res);
                $("#modal-title").text("Nueva Infracción");
                $("#textoBoton").text("Guardar");
                $("#modal-update").modal("show");
            }
        })
    }
    
    function edit(id) {
        $.ajax({
            method: 'get',
            url: `{{ url('infractions') }}/${id}/edit`,
            success: function(res) {
                $('#modal-update').find('.modal-dialog').html(res);
                $("#textoBoton, #modal-title").text("Actualizar Infracción");
                $("#modal-update").modal("show");
            }
        })
    }
    
    function save() {
        $('#formUpdate').on('submit', function(e) {
            e.preventDefault();
            const _form = this;
            const formData = new FormData(_form);
            const url = this.getAttribute('action');
            $.ajax({
                method: 'POST',
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#modal-update').modal("hide");
                    Swal.fire({
                        icon: res.status,
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function(res) {
                    let errors = res.responseJSON?.errors;
                    $(_form).find(`[name]`).removeClass('is-invalid');
                    $(_form).find('.invalid-feedback').remove();
                    if (errors) {
                        for (const [key, value] of Object.entries(errors)) {
                            $(_form).find(`[name='${key}']`).addClass('is-invalid');
                            $(_form).find(`#msg_${key}`).parent().append(`<span class="invalid-feedback">${value}</span>`);
                        }
                    }
                }
            });
        })
    }
    
    function del(id) {
        Swal.fire({
            title: 'Eliminar registro',
            text: "¿Está seguro de querer eliminar el registro?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: `{{ url('infractions') }}/${id}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: res.status,
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(res) {
                        // Manejar error si es necesario
                    }
                });
            }
        })
    }
</script>
@endpush
