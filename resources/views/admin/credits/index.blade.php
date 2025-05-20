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
                                <h4 class="card-title">Kreditlər</h4>
                                    <a href="{{route('credits.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Müştəri</th>
                                                <th>Məhsul</th>
                                                <th>Məbləğ</th>
                                                <th>Ay</th>
                                                <th>Faiz</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($credits as $credit)

                                            <tr>
                                                <th scope="row">{{$credit->id}}</th>
                                                <th scope="row">{{$credit->customer?->name}}</th>
                                                <th scope="row">{{$credit->product?->title}}</th>
                                                <td> {{$credit->price}}</td>
                                                <td> {{$credit->month}}</td>
                                                <td> {{$credit->percent}}</td>
                                                <td>
                                                    <a href="{{route('credits.show',$credit->id)}}" class="btn btn-primary" style="margin-right: 15px" >Show</a>
{{--                                                    <a href="{{route('credits.edit',$credit->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>--}}
{{--                                                    <form action="{{route('credits.destroy', $credit->id)}}" method="post" style="display: inline-block">--}}
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
                                    {{ $credits->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
