@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('sections.update', $section->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$section->translate('en')->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Section</label>
                                    <input class="form-control" readonly type="text" name="type" value="{{$section->type}}">
                                    @if($errors->first('type')) <small class="form-text text-danger">{{$errors->first('type')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq az</label>
                                    <input class="form-control" type="text" name="az_title" value="{{$section->translate('az')->title}}">
                                    @if($errors->first('az_title')) <small class="form-text text-danger">{{$errors->first('az_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{$section->translate('en')->title}}">
                                    @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{$section->translate('ru')->title}}">

                                    @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text az</label>
                                    <textarea  class="form-control" type="text" name="az_description">{{$section->translate('az')->description}}</textarea>
                                    @if($errors->first('az_description')) <small class="form-text text-danger">{{$errors->first('az_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text en</label>
                                    <textarea class="form-control" type="text" name="en_description">{{$section->translate('en')->description}}</textarea>
                                    @if($errors->first('en_description')) <small class="form-text text-danger">{{$errors->first('en_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text ru</label>
                                    <textarea class="form-control" type="text" name="ru_description">{{$section->translate('ru')->description}}</textarea>
                                    @if($errors->first('ru_description')) <small class="form-text text-danger">{{$errors->first('ru_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    @php
                                        $fileExtension = pathinfo($section->image, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array($fileExtension, ['mp4']))
                                        <video width="350" height="250" controls>
                                            <source src="{{ asset('storage/' . $section->image) }}" type="video/mp4">
                                            Sizin brauzeriniz bu videonu dəstəkləmir.
                                        </video>
                                    @else
                                        <img style="width: 350px; height: 250px;" src="{{ asset('storage/' . $section->image) }}" class="uploaded_image" alt="{{ $section->image }}">
                                    @endif

                                    <div class="form-group">
                                        <label>Şəkil və ya video</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <img style="width: 100px; height: 100px;" src="{{asset('storage/' . $section->image1)}}" class="uploaded_image" alt="{{$section->image1}}">
                                    <div class="form-group">
                                        <label >Image 2</label>
                                        <input type="file" name="image1" class="form-control">
                                    </div>
                                    @if($errors->first('image1')) <small class="form-text text-danger">{{$errors->first('image1')}}</small> @endif
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

