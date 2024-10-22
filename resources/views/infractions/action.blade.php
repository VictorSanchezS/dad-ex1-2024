<div class="modal-content">
    <form id="formUpdate"
        action="{{$infraction->id ? route('infractions.update', $infraction) : route('infractions.store')}}"
        method="post">
        <div class="modal-header">
            <h4 class="modal-title" id="modal-title">{{$infraction->id ? 'Editar Infracción' : 'Nueva Infracción'}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @csrf
            @if($infraction->id)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $infraction->id }}">
            @endif

            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" placeholder="Ingrese DNI" name="dni"
                    value="{{ $infraction->dni }}">
                <div id="msg_dni"></div>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="datetime-local" class="form-control" id="fecha" name="fecha"
                    value="{{ is_string($infraction->fecha) ? \Carbon\Carbon::parse($infraction->fecha)->format('Y-m-d\TH:i') : ($infraction->fecha ? $infraction->fecha->format('Y-m-d\TH:i') : '') }}">
                <div id="msg_fecha"></div>
                <!-- <p>Fecha formateada: -->
                    {{ is_string($infraction->fecha) ? \Carbon\Carbon::parse($infraction->fecha)->format('Y-m-d H:i:s') : ($infraction->fecha ? $infraction->fecha->format('Y-m-d H:i:s') : '') }}
                <!-- </p> -->
            </div>

            <div class="form-group">
                <label for="plate">Placa</label>
                <input type="text" class="form-control" id="plate" placeholder="Ingrese placa" name="plate"
                    value="{{ $infraction->plate }}">
                <div id="msg_plate"></div>
            </div>
            <div class="form-group">
                <label for="infraccion">Infracción</label>
                <input type="text" class="form-control" id="infraccion" placeholder="Ingrese infracción"
                    name="infraccion" value="{{ $infraction->infraccion }}">
                <div id="msg_infraccion"></div>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" placeholder="Ingrese descripción"
                    name="description">{{ $infraction->description }}</textarea>
                <div id="msg_description"></div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="textoBoton" onclick="save()">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>