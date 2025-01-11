<form id="alterationForm">
    <div class="row mb-1">
        <div class="col-3">
            Jenis Perubahan
        </div>
        <div class="col">
            <div id="alteration_body-editor" class="textarea"></div>
            <textarea type="text" name="alteration_body" class="d-none">{!! isset($monitoring) ? html_entity_decode($monitoring->alteration?->alteration_body ?? '') : null !!}</textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Peristiwa Risiko yang Terdampak atas Perubahan
        </div>
        <div class="col">
            <div id="alteration_impact-editor" class="textarea"></div>
            <textarea type="text" name="alteration_impact" class="d-none">{!! isset($monitoring) ? html_entity_decode($monitoring->alteration?->alteration_impact ?? '') : null !!}</textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Penjelasan
        </div>
        <div class="col">
            <div id="alteration_description-editor" class="textarea"></div>
            <textarea type="text" name="alteration_description" class="d-none">{!! isset($monitoring) ? html_entity_decode($monitoring->alteration?->alteration_description ?? '') : null !!}</textarea>
        </div>
    </div>
</form>
