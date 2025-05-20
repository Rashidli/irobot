@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('questions.update', $question->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$question->translate('en')->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq az</label>
                                    <input class="form-control" type="text" name="az_title" value="{{$question->translate('az')->title}}">
                                    @if($errors->first('az_title')) <small class="form-text text-danger">{{$errors->first('az_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{$question->translate('en')->title}}">
                                    @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{$question->translate('ru')->title}}">

                                    @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text az</label>
                                    <textarea id="editor_az" class="form-control" type="text" name="az_description">{{$question->translate('az')->description}}</textarea>
                                    @if($errors->first('az_description')) <small class="form-text text-danger">{{$errors->first('az_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text en</label>
                                    <textarea id="editor_en" class="form-control" type="text" name="en_description">{{$question->translate('en')->description}}</textarea>
                                    @if($errors->first('en_description')) <small class="form-text text-danger">{{$errors->first('en_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text ru</label>
                                    <textarea id="editor_ru" class="form-control" type="text" name="ru_description">{{$question->translate('ru')->description}}</textarea>
                                    @if($errors->first('ru_description')) <small class="form-text text-danger">{{$errors->first('ru_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <div class="mb-3 text-center">
                                        @foreach($question->sliders ?? [] as $slider)
                                            <div class="image-container" data-slider-id="{{ $slider->id }}">
                                                <img style="width: 100px; height: 100px;"
                                                     src="{{ asset('storage/' . $slider->image) }}"
                                                     class="uploaded_image" alt="{{ $slider->image }}">
                                                <a class="btn btn-danger btn-sm"
                                                   href="{{ route('delete-slider-image', ['id' => $slider->id]) }}">Delete</a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <label class="col-form-label">Slider</label>
                                    <input class="form-control" type="file" name="sliders[]" multiple>
                                    @if($errors->first('sliders'))
                                        <small class="form-text text-danger">{{ $errors->first('sliders') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$question->is_active == true ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$question->is_active == false ? 'selected' : ''}}>Deactive</option>
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

{{--<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>--}}
{{--<script>--}}
{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor_az' ) )--}}
{{--        .catch( error => {--}}
{{--            console.error( error );--}}
{{--        } );--}}

{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor_en' ) )--}}
{{--        .catch( error => {--}}
{{--            console.error( error );--}}
{{--        } );--}}

{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor_ru' ) )--}}
{{--        .catch( error => {--}}
{{--            console.error( error );--}}
{{--        } );--}}

{{--</script>--}}
