<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="alterationTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th>Jenis Perubahan</th>
                    <th>Peristiwa Risiko yang Terdampak atas Perubahan</th>
                    <th>Penjelasan</th>
                </tr>
            </thead>
            <tbody>
                @isset($monitoring)
                    <tr>
                        <td>{!! html_entity_decode($monitoring->alteration->body) !!}</td>
                        <td>{!! html_entity_decode($monitoring->alteration->impact) !!}</td>
                        <td>{!! html_entity_decode($monitoring->alteration->description) !!}</td>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
</div>
