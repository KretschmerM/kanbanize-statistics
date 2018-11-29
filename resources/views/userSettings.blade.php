@include('layouts.nav')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Settings</div>

                <div class="card-body">
                    @csrf
                    <div class="form-group row">
                        <label for="kanbanize_key" class="col-sm-4 col-form-label text-md-right"></label>

                        <div class="col-md-6">
                            <input id="kanbanize_key" type="text" name="kanbanize_key">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

