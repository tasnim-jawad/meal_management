@extends('admin.master')

@section('content')
    <div id="calendar"></div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">All Batches</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr>
                        <th>srl#</th>
                        <th>Department</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1 @endphp
                    @foreach ($datas as $batch)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{$batch->department->department ?? ""}}</td>
                            <td>{{$batch->batch_name ?? ""}}</td>
                            <td>{{$batch->status ?? ""}}</td>
                            <td>
                                <a href="{{ route('batch.edit', $batch->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                @if ($batch->status == 1)
                                    <a href="javascript:void(0)"
                                        onclick="confirmAction('{{ $batch->id }}',`soft_delete`)"
                                        class="btn btn-warning btn-sm">Deactiv</a>
                                    <form id="batch-soft_delete-{{ $batch->id }}" action="{{Route('batch.soft_delete')}}"
                                        method="POST" style="display: none">
                                    @csrf
                                        <input type="text" name="id" value="{{$batch->id}}">
                                    </form>
                                @else
                                    <a href="javascript:void(0)"
                                        onclick="confirmAction('{{ $batch->id }}',`restore`)"
                                        class="btn btn-info btn-sm">Active</a>
                                    <form id="batch-restore-{{ $batch->id }}" action="{{Route('batch.restore')}}"
                                        method="POST" style="display: none">
                                    @csrf
                                        <input type="text" name="id" value="{{$batch->id}}">
                                    </form>
                                @endif
                                <a  href="javascript:void(0)"
                                    onclick="confirmAction('{{ $batch->id }}',`destroy`)"
                                    class="btn btn-danger btn-sm">Delete
                                </a>

                                <form id="batch-destroy-{{ $batch->id }}" action="{{Route('batch.destroy')}}"
                                    method="POST" style="display: none">
                                @csrf
                                    <input type="text" name="id" value="{{$batch->id}}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('end_js')
    <script>
        function confirmAction(batch_id , button) {
            if (confirm('Are you sure you want to do this?')) {
                if(button == "soft_delete"){
                    document.getElementById(`batch-soft_delete-${batch_id}`).submit()
                }else if(button == "destroy"){
                    document.getElementById(`batch-destroy-${batch_id}`).submit()
                }else if(button == "restore"){
                    document.getElementById(`batch-restore-${batch_id}`).submit();
                }
            }
        }
    </script>
@endpush
