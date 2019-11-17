@extends('admin.layouts.app')

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
<script src="{{ asset('js/admin/advertising.js') }}" defer></script>
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
        <div class="alert alert-info h4">
            Note: Use @{{ $ad::getCode(ad_id) }} in templates to show ad. Don't forget to replace ad_id from below table.
        </div>
        <div class="alert alert-info h4">
            Note: Use @{{ $ad::getRandomCode(ad_id_1, ad_id_2, ...) }} in templates to show random ad.
        </div>
        <div class="card">
            <div class="card-header">
                <span class="h3">Advertising</span>
                <span class="float-right">
                    <button class="btn bg-success text-white" data-toggle="modal" data-target="#addAdModal">Add New Ad</button>
                </span>
            </div>
            <div class="card-body">
                <table class="dataTable text-center" id="adsTable">
                    <thead>
                        <tr>
                            <th>Ad ID</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ad::all() as $adObj)
                            <tr>
                                <td>{{ $adObj->ad_id }}</td>
                                <td>{{ $adObj->ad_name }}</td>
                                <td>{{ $adObj->ad_size }}</td>
                                <td>{{ $adObj->ad_code }}</td>
                                <td>
                                    <a onclick="editAd('{{ $adObj->ad_id }}', '{{ $adObj->ad_name }}', '{{ $adObj->ad_size }}', '{{ $adObj->ad_code }}')" data-toggle='tooltip' data-placement='bottom' title='Edit'><i class="fas fa-edit fa-2x text-primary"></i></a>
                                    <a href="{{ url('/admin/advertising/delete') }}?ad_id={{ $adObj->ad_id }}" onclick="return confirm('Are you sure?')" data-toggle='tooltip' data-placement='bottom' title='Delete'><i class="fas fa-trash fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Ad Modal -->
<div class="modal fade" id="addAdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="add-ad-form" class="" action="{{ action('Admin\AdvertisingController@addAd') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Ad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Ad Name</label>
                            <input type="text" name="ad_name" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Ad Size</label>
                            <input type="text" name="ad_size" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Ad Code</label>
                            <textarea name="ad_code" rows="8" cols="80" class="form-control"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Ad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Ad Modal -->
<div class="modal fade" id="editAdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="edit-ad-form" class="" action="{{ action('Admin\AdvertisingController@editAd') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit ad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        @csrf
                        <input type="hidden" name="ad_id" id="edit-ad-id" class="form-control" value="" />
                        <div class="form-group">
                            <label for="">Ad Name</label>
                            <input type="text" name="ad_name" id="edit-ad-name" class="form-control" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Ad Size</label>
                            <input type="text" name="ad_size" class="form-control" id="edit-ad-size" value="" />
                        </div>
                        <div class="form-group">
                            <label for="">Ad Code</label>
                            <textarea name="ad_code" class="form-control" id="edit-ad-code" rows="8" cols="80"></textarea>
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
function editAd(ad_id, ad_name, ad_size, ad_code) {
    $("#edit-ad-id").val(ad_id);
    $("#edit-ad-name").val(ad_name);
    $("#edit-ad-size").val(ad_size);
    $("#edit-ad-code").val(ad_code);
    $("#editAdModal").modal('show');
}
</script>
@endsection
