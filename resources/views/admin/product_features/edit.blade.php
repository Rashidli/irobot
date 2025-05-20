@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <form action="{{ route('products.product_features.update', [$product->id, $product_feature->id]) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $product_feature->translate('en')->title }}</h4>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq az</label>
                                    <input class="form-control" type="text" name="az_title" value="{{ $product_feature->translate('az')->title }}">
                                    @if($errors->first('az_title'))
                                        <small class="form-text text-danger">{{ $errors->first('az_title') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{ $product_feature->translate('en')->title }}">
                                    @if($errors->first('en_title'))
                                        <small class="form-text text-danger">{{ $errors->first('en_title') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{ $product_feature->translate('ru')->title }}">
                                    @if($errors->first('ru_title'))
                                        <small class="form-text text-danger">{{ $errors->first('ru_title') }}</small>
                                    @endif
                                </div>

{{--                                <div class="mb-3">--}}
{{--                                    <label class="col-form-label">Text az</label>--}}
{{--                                    <textarea  class="form-control" name="az_description">{{ $product_feature->translate('az')->description }}</textarea>--}}
{{--                                    @if($errors->first('az_description'))--}}
{{--                                        <small class="form-text text-danger">{{ $errors->first('az_description') }}</small>--}}
{{--                                    @endif--}}
{{--                                </div>--}}

{{--                                <div class="mb-3">--}}
{{--                                    <label class="col-form-label">Text en</label>--}}
{{--                                    <textarea  class="form-control" name="en_description">{{ $product_feature->translate('en')->description }}</textarea>--}}
{{--                                    @if($errors->first('en_description'))--}}
{{--                                        <small class="form-text text-danger">{{ $errors->first('en_description') }}</small>--}}
{{--                                    @endif--}}
{{--                                </div>--}}

{{--                                <div class="mb-3">--}}
{{--                                    <label class="col-form-label">Text ru</label>--}}
{{--                                    <textarea  class="form-control" name="ru_description">{{ $product_feature->translate('ru')->description }}</textarea>--}}
{{--                                    @if($errors->first('ru_description'))--}}
{{--                                        <small class="form-text text-danger">{{ $errors->first('ru_description') }}</small>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
                                <div class="mb-3">
                                    <img style="width: 100px; height: 100px;" src="{{ asset('storage/' . $product_feature->image) }}" class="uploaded_image" alt="{{ $product_feature->image }}">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    @if($errors->first('image')) <small class="form-text text-danger">{{ $errors->first('image') }}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ $product_feature->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$product_feature->is_active ? 'selected' : '' }}>Deactive</option>
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
