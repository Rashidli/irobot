@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('percentages.update', $percentage->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$percentage->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Ay</label>
                                    <input class="form-control" type="text" name="month" value="{{$percentage->month}}">
                                    @if($errors->first('month')) <small class="form-text text-danger">{{$errors->first('month')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Faiz</label>
                                    <input class="form-control" type="text" name="percent" value="{{$percentage->percent}}">
                                    @if($errors->first('percent')) <small class="form-text text-danger">{{$errors->first('percent')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary">Yadda saxla</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@include('admin.includes.footer')

