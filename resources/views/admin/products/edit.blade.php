@include('admin.includes.header')
<style>
    #levelClutterRange {
        width: 100%;
    }
    .d-flex span {
        font-size: 14px;
        color: #555;
    }
    .slider-section {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: start;
    }

    .slider-image-container {
        display: inline-block;
        position: relative;
        margin: 10px;
    }

    .slider-image-container img {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .slider-image-container img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    .slider-image-container .delete-slider-button {
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 10px;
        padding: 5px 8px;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .slider-image-container:hover .delete-slider-button {
        opacity: 1;
    }

    .slider-form-group {
        margin-top: 20px;
        width: 100%;
    }

    .slider-file-input {
        border: 1px solid #ccc;
        padding: 8px;
        border-radius: 5px;
        width: 100%;
    }


</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <nav aria-label="breadcrumb" style="margin-bottom: 20px;">
                            <ol class="breadcrumb bg-light p-3 rounded">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Siyahı</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->translate('az')?->title }}</li>
                            </ol>
                        </nav>

                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="langTabs" role="tablist">
                            @foreach(['az', 'en', 'ru'] as $lang)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ strtoupper($lang) }}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="langTabsContent">
                            @foreach(['az', 'en', 'ru'] as $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">
                                    <div class="row">
                                        <!-- Title Section -->
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">Başlıq</div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Başlıq* {{ $lang }}</label>
                                                        <input class="form-control" type="text" name="{{ $lang }}_title" value="{{ $product->translate($lang)->title }}">
                                                        @if($errors->first($lang.'_title'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_title') }}</small>
                                                        @endif
                                                    </div>
{{--                                                    <div class="mb-3">--}}
{{--                                                        <label class="col-form-label">Rəngi* {{ $lang }}</label>--}}
{{--                                                        <input class="form-control" type="text" name="{{ $lang }}_color" value="{{ $product->translate($lang)->color }}">--}}
{{--                                                        @if($errors->first($lang.'_color'))--}}
{{--                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_color') }}</small>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description Section -->
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">Mətn</div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Text* {{ $lang }}</label>
                                                        <textarea id="editor_{{ $lang }}" class="form-control" name="{{ $lang }}_description">{{ $product->translate($lang)->description }}</textarea>
                                                        @if($errors->first($lang.'_description'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_description') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Alt & Title Tags Section -->
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">Alt və Title Taglar</div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Alt tag {{ $lang }}</label>
                                                        <input class="form-control" type="text" name="{{ $lang }}_img_alt" value="{{ $product->translate($lang)->img_alt }}">
                                                        @if($errors->first($lang.'_img_alt'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_img_alt') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Title tag {{ $lang }}</label>
                                                        <input class="form-control" type="text" name="{{ $lang }}_img_title" value="{{ $product->translate($lang)->img_title }}">
                                                        @if($errors->first($lang.'_img_title'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_img_title') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Meta Tags Section -->
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">Meta Taglar</div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Meta title {{ $lang }}</label>
                                                        <input class="form-control" type="text" name="{{ $lang }}_meta_title" value="{{ $product->translate($lang)->meta_title }}">
                                                        @if($errors->first($lang.'_meta_title'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_meta_title') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Meta description {{ $lang }}</label>
                                                        <textarea class="form-control" name="{{ $lang }}_meta_description">{{ $product->translate($lang)->meta_description }}</textarea>
                                                        @if($errors->first($lang.'_meta_description'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_meta_description') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Meta keywords {{ $lang }}</label>
                                                        <textarea class="form-control" name="{{ $lang }}_meta_keywords">{{ $product->translate($lang)->meta_keywords }}</textarea>
                                                        @if($errors->first($lang.'_meta_keywords'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_meta_keywords') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">Slider</div>
                                                <div class="card-body slider-section">
                                                    @foreach($product->sliders as $slider)
                                                        <div class="slider-image-container" data-slider-id="{{ $slider->id }}">
                                                            <img src="{{ asset('storage/' . $slider->image) }}" class="uploaded-image" alt="{{ $slider->image }}">
                                                            <a class="btn btn-danger btn-sm delete-slider-button" href="{{ route('delete-slider-image', ['id' => $slider->id]) }}">Sil</a>
                                                        </div>
                                                    @endforeach
                                                    <div class="slider-form-group">
                                                        <label for="slider-images">Slider Şəkillər:</label>
                                                        <input id="slider-images" type="file" name="sliders[]" multiple class="slider-file-input">
                                                        @if($errors->first('slider_images'))
                                                            <small class="form-text text-danger">{{ $errors->first('sliders') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <!-- Image Section -->
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">Şəkil(780-480)</div>
                                    <div class="card-body">
                                        <div class="mb-3 text-center">
                                            <img style="width: 100px; height: 100px;" src="{{ asset('storage/' . $product->image) }}" class="uploaded_image" alt="{{ $product->image }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Şəkil*(780-480)</label>
                                            <input type="file" name="image" class="form-control">
                                            @if($errors->first('image'))
                                                <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">


                            <!-- Status Section -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Stokda var? </label>
                                    <input  type="checkbox" {{$product->is_stock ? 'checked' : ''}} name="is_stock">
                                    @if($errors->first('is_stock'))
                                        <small class="form-text text-danger">{{ $errors->first('is_stock') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Yeni məhsul? </label>
                                    <input  type="checkbox" {{$product->is_new ? 'checked' : ''}} name="is_new">
                                    @if($errors->first('is_new'))
                                        <small class="form-text text-danger">{{ $errors->first('is_new') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Çox satılan məhsul? </label>
                                    <input  type="checkbox" {{$product->is_bestseller ? 'checked' : ''}} name="is_bestseller">
                                    @if($errors->first('is_bestseller'))
                                        <small class="form-text text-danger">{{ $errors->first('is_bestseller') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Paket məhsuldur? </label>
                                    <input  type="checkbox" {{$product->is_paket ? 'checked' : ''}} name="is_paket">
                                    @if($errors->first('is_paket'))
                                        <small class="form-text text-danger">{{ $errors->first('is_paket') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Məhsulun qiyməti </label>
                                    <input  type="number" class="form-control" value="{{$product->price}}" name="price">
                                    @if($errors->first('price'))
                                        <small class="form-text text-danger">{{ $errors->first('price') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Otaq sahəsi </label>
                                    <input  type="number" class="form-control" value="{{$product->room_area}}" name="room_area">
                                    @if($errors->first('room_area'))
                                        <small class="form-text text-danger">{{ $errors->first('room_area') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Məhsulun kodu </label>
                                    <input  type="text" class="form-control" value="{{$product->code}}" name="code">
                                    @if($errors->first('code'))
                                        <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Kateqoriya</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{$category->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('category_id'))
                                        <small class="form-text text-danger">{{ $errors->first('category_id') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Növü</label>
                                    <select name="type_id" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}" {{ $product->type_id == $type->id ? 'selected' : '' }}>
                                                {{$type->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('type_id'))
                                        <small class="form-text text-danger">{{ $errors->first('type_id') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Seriyası</label>
                                    <select name="product_serie_id" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach($product_series as $product_serie)
                                            <option value="{{$product_serie->id}}" {{ $product->product_serie_id == $product_serie->id ? 'selected' : '' }}>
                                                {{$product_serie->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('product_serie_id'))
                                        <small class="form-text text-danger">{{ $errors->first('product_serie_id') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Aksesurların seç</label>
                                    <select name="accessories[]" class="form-control js-example-basic-single" multiple>
                                        <option value="">Seçin</option>
                                        @foreach($accessories as $accessory)
                                            <option value="{{$accessory->id}}" {{$product->accessories->contains($accessory->id) ? 'selected' : ''}}>
                                                {{$accessory->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('accessories'))
                                        <small class="form-text text-danger">{{ $errors->first('accessories') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Toz haradan gəlir?</label>
                                    <select name="mess_coming" class="form-control">
                                        <option value="parent" {{$product->mess_coming == 'parent' ? 'selected' : ''}}>Valideynlər</option>
                                        <option value="animals" {{$product->mess_coming == 'animals' ? 'selected' : ''}}>Heyvanlar</option>
                                        <option value="children" {{$product->mess_coming == 'children' ? 'selected' : ''}}>Uşaqlar</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Mərtəbə seçin?</label>
                                    <select name="floor_home" class="form-control">
                                        <option value="1" {{$product->floor_home == '1' ? 'selected' : ''}}>1</option>
                                        <option value="2" {{$product->floor_home == '2' ? 'selected' : ''}}>2</option>
                                        <option value="3" {{$product->floor_home == '3' ? 'selected' : ''}}>3</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Dağınıqlıq səviyyəsi</label>
                                    <input type="range" name="level_clutter" min="1" max="3"
                                           value="{{ $product->level_clutter }}" class="form-range" id="levelClutterRange">
                                    <div class="d-flex justify-content-between mt-2">
                                        <span>1</span>
                                        <span>2</span>
                                        <span>3</span>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">Status</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="active" name="is_active" value="1" {{ $product->is_active == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">Active</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="inactive" name="is_active" value="0" {{ $product->is_active == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.includes.footer')
