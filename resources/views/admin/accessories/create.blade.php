@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('accessories.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Əlavə et</h4>
                    </div>
                    <div class="card-body">
                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="languageTab" role="tablist">
                            @foreach(['az', 'en', 'ru'] as $lang)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if($loop->first) active @endif" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="true">
                                        {{ strtoupper($lang) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <br><br>
                        <div class="tab-content" id="languageTabContent">
                            @foreach(['az', 'en', 'ru'] as $lang)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Başlıq və Mətn</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Başlıq* {{ $lang }}</label>
                                                <input class="form-control" type="text" value="{{old($lang . '_title')}}" name="{{ $lang }}_title">
                                                @if($errors->first("{$lang}_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Text* {{ $lang }}</label>
                                                <textarea id="editor_{{ $lang }}" class="form-control" name="{{ $lang }}_description">{{old($lang . '_description')}}</textarea>
                                                @if($errors->first("{$lang}_description"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_description") }}</small>
                                                @endif
                                            </div>

                                            <h5 class="mb-3">Şəkil Etiketləri</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Title tag {{ $lang }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_img_title" value="{{old($lang . '_img_title')}}">
                                                @if($errors->first("{$lang}_img_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_img_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Alt tag {{ $lang }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_img_alt" value="{{old($lang . '_img_alt')}}">
                                                @if($errors->first("{$lang}_img_alt"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_img_alt") }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 class="mb-3">Meta Tags</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta title {{ $lang }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_meta_title" value="{{ old("{$lang}_meta_title") }}">
                                                @if($errors->first("{$lang}_meta_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta description {{ $lang }}</label>
                                                <textarea class="form-control" name="{{ $lang }}_meta_description">{{ old("{$lang}_meta_description") }}</textarea>
                                                @if($errors->first("{$lang}_meta_description"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_description") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta keywords {{ $lang }}</label>
                                                <textarea class="form-control" name="{{ $lang }}_meta_keywords">{{ old("{$lang}_meta_keywords") }}</textarea>
                                                @if($errors->first("{$lang}_meta_keywords"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_keywords") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Stokda var?</label>
                                    <input type="checkbox" name="is_stock" value="{{old('is_stock')}}">
                                    @if($errors->first("is_stock"))
                                        <small class="form-text text-danger">{{ $errors->first("is_stock") }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Çox satılan məhsul?</label>
                                    <input type="checkbox" name="is_bestseller" value="{{old('is_bestseller')}}">
                                    @if($errors->first("is_bestseller"))
                                        <small class="form-text text-danger">{{ $errors->first("is_bestseller") }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Məhsul qiyməti</label>
                                    <input class="form-control" type="number" name="price" value="{{old('price')}}">
                                    @if($errors->first("price"))
                                        <small class="form-text text-danger">{{ $errors->first("price") }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Endirimli qiyməti</label>
                                    <input class="form-control" type="number" name="discounted_price" value="{{old('discounted_price')}}">
                                    @if($errors->first("discounted_price"))
                                        <small class="form-text text-danger">{{ $errors->first("discounted_price") }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Otaq sahəsi</label>
                                    <input class="form-control" type="number" name="room_area" value="{{old('room_area')}}">
                                    @if($errors->first("room_area"))
                                        <small class="form-text text-danger">{{ $errors->first("room_area") }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Məhsul kodu</label>
                                    <input class="form-control" type="text" name="code" value="{{old('code')}}">
                                    @if($errors->first("code"))
                                        <small class="form-text text-danger">{{ $errors->first("code") }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Şəkillər</label>
                                    <input class="form-control" type="file" name="slider_images[]" multiple>
                                    @if($errors->first('slider_images')) <small class="form-text text-danger">{{$errors->first('slider_images')}}</small> @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Kateqoriya</label>
                                    <select name="accessory_category_id" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" >
                                                {{$category->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Növlər</label>
                                    <select name="accessory_type_id" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}" >
                                                {{$type->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Seriyası</label>
                                    <select name="accessory_serie_id" class="form-control">
                                        <option value="">Seçin</option>
                                        @foreach($series as $serie)
                                            <option value="{{$serie->id}}" >
                                                {{$serie->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Şəkil*(780-480)</label>
                                    <input class="form-control" type="file" name="image">
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3 text-end">
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
