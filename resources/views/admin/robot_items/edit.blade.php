@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            {{-- Nested route update form --}}
            <form action="{{ route('robots.robot_items.update', [$robot->id, $robot_item->id]) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $robot_item->translate('en')->title }}</h4>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq az</label>
                                    <input class="form-control" type="text" name="az_title" value="{{ $robot_item->translate('az')->title }}">
                                    @error('az_title') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{ $robot_item->translate('en')->title }}">
                                    @error('en_title') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{ $robot_item->translate('ru')->title }}">
                                    @error('ru_title') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text az</label>
                                    <textarea class="form-control" name="az_description">{{ $robot_item->translate('az')->description }}</textarea>
                                    @error('az_description') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text en</label>
                                    <textarea class="form-control" name="en_description">{{ $robot_item->translate('en')->description }}</textarea>
                                    @error('en_description') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text ru</label>
                                    <textarea class="form-control" name="ru_description">{{ $robot_item->translate('ru')->description }}</textarea>
                                    @error('ru_description') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ $robot_item->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$robot_item->is_active ? 'selected' : '' }}>Deactive</option>
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
