@extends('admin.layouts.app')

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
<script src="{{ asset('js/admin/domains.js') }}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                <span class="h3">Domains</span>
                <span class="float-right">
                    <button class="btn bg-success text-white" data-toggle="modal" data-target="#addDomainModal">Add Domain</button>
                </span>
            </div>
            <div class="card-body">
                <table class="dataTable text-center" id="domainsTable">
                    <thead>
                        <tr>
                            <th>Domain ID</th>
                            <th>Added At</th>
                            <th>Updated At</th>
                            <th>Domain</th>
                            <th>Expiry Date</th>
                            <th>Added By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['domains'] as $domain)
                            <tr>
                                <td>{{ $domain->domain_id }}</td>
                                <td><time class="timeago" datetime="{{ $domain->created_at->format('c') }}"></time></td>
                                <td><time class="timeago" datetime="{{ $domain->updated_at }}"></time></td>
                                <td>{{ $domain->name }}</td>
                                <td>{{ $domain->expiry_date }}</td>
                                <td>{{ $domain->added_by }}</td>
                                <td>
                                    <div class="badge {{ ($domain->status == 'active') ? 'badge-success' : 'badge-danger' }}">
                                        {{ $domain->status }}
                                    </div>
                                </td>
                                <td>
                                    <a onclick="editDomain('{{ $domain->domain_id }}', '{{ $domain->name }}', '{{ $domain->expiry_date }}', '{{ $domain->added_by }}', '{{ $domain->type }}', '{{ $domain->status }}')" data-toggle='tooltip' data-placement='bottom' title='Edit'><i class="fas fa-edit fa-2x text-primary"></i></a>
                                    <a href="{{ url('/admin/domains/delete') }}?domain_id={{ $domain->domain_id }}" onclick="return confirm('All email accounts and their inboxes related to this domain will deleted. Are you sure?')" data-toggle='tooltip' data-placement='bottom' title='Delete'><i class="fas fa-trash fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Domain Modal -->
<div class="modal fade" id="addDomainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="add-domain-form" class="" action="{{ action('Admin\DomainsController@addDomain') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Domain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Domain</label>
                            <input type="text" name="domain" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Expiry Date</label>
                            <input type="text" name="expiry_date" class="form-control datepicker" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Added By</label>
                            <select class="form-control" name="added_by">
                                <option value="admin" selected>Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Type</label>
                            <select class="form-control" name="type">
                                <option value="receive" selected>Receive</option>
                                <option value="send">Send</option>
                                <option value="send_receive">Send & Receive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select class="form-control" name="status">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Domain</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Domain Modal -->
<div class="modal fade" id="editDomainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="edit-domain-form" class="" action="{{ action('Admin\DomainsController@editDomain') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Domain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        @csrf
                        <input type="hidden" name="domain_id" id="edit-domain-id" class="form-control" value="" />
                        <div class="form-group">
                            <label for="">Domain</label>
                            <input type="text" name="name" id="edit-domain" class="form-control" value="" readonly />
                        </div>
                        <div class="form-group">
                            <label for="">Expiry Date</label>
                            <input type="text" name="expiry_date" class="form-control datepicker" id="edit-expiry-date" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Added By</label>
                            <select class="form-control" name="added_by" id="edit-added-by">
                                <option value="admin" selected>Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Type</label>
                            <select class="form-control" name="type" id="edit-type" required>
                                <option value="receive" selected>Receive</option>
                                <option value="send">Send</option>
                                <option value="send_receive">Send & Receive</option>
                            </select>
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
function editDomain(domain_id, domain, expiry_date, added_by, type, status) {
    $("#edit-domain-id").val(domain_id);
    $("#edit-domain").val(domain);
    $("#edit-expiry-date").val(expiry_date);
    $("#edit-added-by").val(added_by);
    $("#edit-type").val(type);
    $("#edit-status").val(status);
    $("#editDomainModal").modal('show');
}
</script>
@endsection
