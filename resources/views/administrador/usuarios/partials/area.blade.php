
<div class="form-row">
    <div class="form-group col-md-6">
        <label class="titulo-dato"><strong><span class="text-danger">*</span> Area</strong></label>
        <select id="area_id" name="area_id" class="custom-select select2" autocomplete="off" required>
            <option selected></option>
            @foreach ($areas as $area)
                <option value="{{$area->area_id}}" {{ (old("area_id") && old("area_id") == $area->area_id) || (isset($usuario->area->area_id) && ($usuario->area->area_id == $area->area_id)) ? "selected" : "" }}> {{ $area->identificador }} - {{ $area->nombre }}</option>
            @endforeach
        </select>
    </div>
</div>
        


