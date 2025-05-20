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
                                <h4 class="card-title">Aylar və faziləri</h4>
                                    <a href="{{route('percentages.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Ay</th>
                                                <th>Faiz</th>
{{--                                                <th>Status</th>--}}
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($percentages as $percentage)

                                            <tr>
                                                <th scope="row">{{$percentage->id}}</th>
                                                <th scope="row">{{$percentage->month}}</th>
                                                <th scope="row">{{$percentage->percent}}</th>
{{--                                                <td><img src="{{asset('storage/'.$percentage->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
{{--                                                <td>{{$percentage->is_active ? 'Active' : 'Deactive'}}</td>--}}
                                                <td>
                                                    <a href="{{route('percentages.edit',$percentage->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                    <form action="{{route('percentages.destroy', $percentage->id)}}" method="post" style="display: inline-block">
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
                                    {{ $percentages->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
