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
                            <h4 class="card-title">Kredit detalları</h4>

                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">

                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Ödəmə tarixi</th>
                                        <th>Aylıq məbləğ</th>
                                        <th>Qalıq məbləğ</th>
                                        <th>Satutus</th>
{{--                                        <th>Əməliyyat</th>--}}
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($credit_items as $key => $credit_item)

                                        <tr>
                                            <td >{{$key+1}}</td>
                                            <td> {{$credit_item->date->format('d/m/Y')}}</td>
                                            <td> {{$credit_item->monthly_payment}}</td>
                                            <td> {{$credit_item->remaining_amount}}</td>
                                            <td><a class="btn {{$credit_item->status ?  'btn-success': 'btn-danger'}}" href="{{route('toggle_status', $credit_item->id)}}">{{$credit_item->status ? 'Ödənilib' : 'Ödənilməyib'}}</a></td>
{{--                                            <td>--}}
{{--                                                <a href="{{route('credit_items.show',$credit_item->id)}}" class="btn btn-primary" style="margin-right: 15px" >Show</a>--}}
{{--                                                <a href="{{route('credit_items.edit',$credit_item->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>--}}
{{--                                                <form action="{{route('credit_items.destroy', $credit_item->id)}}" method="post" style="display: inline-block">--}}
{{--                                                    {{ method_field('DELETE') }}--}}
{{--                                                    @csrf--}}
{{--                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>--}}
{{--                                                </form>--}}
{{--                                            </td>--}}
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                                <br>
{{--                                {{ $credit_item->links('admin.vendor.pagination.bootstrap-5') }}--}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



@include('admin.includes.footer')
