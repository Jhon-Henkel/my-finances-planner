@php
    use App\Enums\ViewEnum;
@endphp
@extends(ViewEnum::VIEW_BASE)
@section('content')
    <h3 class="mt-2">Ganhos Futuros</h3>
    <hr>
    <table class="table table-dark table-striped table-sm table-hover table-bordered" id="dataTable">
        <thead class="table-dark">
            <tr>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>E</td>
                <td>F</td>
                <td>G</td>
                <td>H</td>
            </tr>
        </tbody>
    </table>
    <hr>
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
    <script type="text/javascript" src="resources/js/tools/stringTools.js"></script>
@endsection