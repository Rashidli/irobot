@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('mains.update', $main->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <video style="width: 350px; height: 200px;" class="uploaded_video" controls>
                                        <source src="{{asset('storage/' . $main->image)}}" >
                                    </video>
                                    <div class="form-group">
                                        <label>video</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{$errors->first('image')}}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Məhsulları seç</label>
                                    <select name="products[]" class="form-control js-example-basic-single" multiple>
                                        <option value="">Seçin</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}" {{$main->products->contains($product->id) ? 'selected' : ''}}>
                                                {{$product->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('accessories'))
                                        <small class="form-text text-danger">{{ $errors->first('accessories') }}</small>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$main->is_active  ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{!$main->is_active  ? 'selected' : ''}}>Deactive</option>
                                    </select>
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
