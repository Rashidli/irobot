@include('admin.includes.header')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if(session('message'))
                                    <div class="alert alert-success">{{session('message')}}</div>
                                @endif
                                <h4 class="card-title">Aksesuar Növləri</h4>
                                    <a href="{{route('accessory_types.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Başlıq</th>
                                                <th>Status</th>
                                               <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($accessory_types as $accessory_type)

                                            <tr>
                                                <th scope="row">{{$accessory_type->id}}</th>
                                                <th scope="row">{{$accessory_type->title}}</th>
{{--                                                <td><img src="{{asset('storage/'.$accessory_type->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                                <td>{{$accessory_type->is_active ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a href="{{route('accessory_types.edit',$accessory_type->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                    <form action="{{route('accessory_types.destroy', $accessory_type->id)}}" method="post" style="display: inline-block">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" accessory_type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $accessory_types->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
