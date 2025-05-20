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
                                <h4 class="card-title">Robot app hero</h4>
                                    <a href="{{route('app_mains.create')}}" class="btn btn-primary">+</a>
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
                                        @foreach($app_mains as $app_main)

                                            <tr>
                                                <th scope="row">{{$app_main->id}}</th>
                                                <th scope="row">{{$app_main->title}}</th>
{{--                                                <td><img src="{{asset('storage/'.$app_main->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                                <td>{{$app_main->is_active == true ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a href="{{route('app_mains.edit',$app_main->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
{{--                                                    <form action="{{route('app_mains.destroy', $app_main->id)}}" method="post" style="display: inline-block">--}}
{{--                                                        {{ method_field('DELETE') }}--}}
{{--                                                        @csrf--}}
{{--                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>--}}
{{--                                                    </form>--}}
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $app_mains->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
