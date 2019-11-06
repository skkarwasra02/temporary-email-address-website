@extends('admin.layouts.app')

@section('js')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
@endsection

@section('content')

@if(session('success'))
<div class="row mx-auto">
    <div class="alert alert-success" style="margin-left:15px;margin-right:15px;">
        {{ session('success') }}
    </div>
</div>
@endif
<div class="row mx-auto">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="h3">Cron Jobs</span>
            </div>
            <div class="card-body">
                <table class="dataTable text-center" id="domainsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cron Name</th>
                            <th>Cron Schedule</th>
                            <th>Last Execution</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size:18px;">
                        @foreach($data['cron_jobs'] as $cron_job)
                            <tr>
                                <td>{{ $cron_job->id }}</td>
                                <td>{{ $cron_job->cron_name }}</td>
                                <td>{{ $cron_job->cron_schedule }}</td>
                                <td>{{ $cron_job->last_execution }}</td>
                                <td>
                                    <div class="badge {{ ($cron_job->status == 'active') ? 'badge-success' : 'badge-danger' }}">
                                        {{ $cron_job->status }}
                                    </div>
                                </td>
                                <td>
                                    <a onclick="editCron('{{ $cron_job->id }}', '{{ $cron_job->cron_name }}', '{{ $cron_job->cron_schedule }}', '{{ $cron_job->status }}')" data-toggle='tooltip' data-placement='bottom' title='Edit'><i class="fas fa-edit fa-2x text-primary"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Domain Modal -->
<div class="modal fade" id="editCronModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="edit-cron-form" class="" action="{{ action('Admin\CronController@editCron') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Cron</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="edit-cron-id" class="form-control" value="" />
                        <div class="form-group">
                            <label for="">Cron Name</label>
                            <input type="text" name="cron_name" id="edit-cron-name" class="form-control" value="" disabled readonly />
                        </div>
                        <div class="form-group">
                            <label for="">Cron Schedule</label>
                            <input type="text" name="cron_schedule" class="form-control" id="edit-cron-schedule" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select class="form-control" name="status" id="edit-status" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" defer>
function editCron(id, cron_name, cron_schedule, status) {
    $("#edit-cron-id").val(id);
    $("#edit-cron-name").val(cron_name);
    $("#edit-cron-schedule").val(cron_schedule);
    $("#edit-status").val(status);
    $("#editCronModal").modal('show');
}
</script>
@endsection
