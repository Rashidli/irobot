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
                                <h4 class="card-title">{{$robot->title}} </h4>
                                    <a href="{{route('robots.robot_items.create',$robot)}}" class="btn btn-primary">+</a>
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

                                        @foreach($robot_items as $robot_item)

                                            <tr>
                                                <th scope="row">{{$robot_item->id}}</th>
                                                <th scope="row">{{$robot_item->title}}</th>
                                                <td>{{$robot_item->is_active  ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a href="{{route('robots.robot_items.edit',[$robot->id, $robot_item->id])}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                    <form action="{{route('robots.robot_items.destroy', [$robot->id, $robot_item->id])}}" method="post" style="display: inline-block">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $robot_items->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@include('admin.includes.footer')
