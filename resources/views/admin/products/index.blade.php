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
                            <h4 class="card-title">Məhsullar</h4>
                               <a href="{{route('products.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Başlıq</th>
                                        <th>Rəng</th>
                                        <th>Xüsusiyətləri</th>
                                        <th>Faqs</th>
                                        <th>Detalları</th>
                                        <th>Status</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($products as $product)

                                        <tr>
                                            <th scope="row">{{$product->id}}</th>
                                            <th scope="row">{{$product->title}}</th>
                                            <th scope="row"><a class="btn btn-info" href="{{ route('products.product_colors.index', $product) }}">Rəng</a></th>
                                            <th scope="row"><a class="btn btn-info" href="{{ route('products.product_features.index', $product) }}">Xüsusiyətləri</a></th>
                                            <th scope="row"><a class="btn btn-info" href="{{ route('products.product_faqs.index', $product) }}">Faqs</a></th>
                                            <th scope="row"><a class="btn btn-info" href="{{ route('products.product_details.index', $product) }}">Detalları</a></th>
                                            {{--                                                <td><img src="{{asset('storage/'.$product->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                            <td>{{$product->is_active ? 'Active' : 'Deactive'}}</td>
                                            <td>
                                                <a href="{{route('products.edit',$product->id)}}" class="btn btn-primary"
                                                   style="margin-right: 15px">Edit</a>
                                                <form action="{{route('products.destroy', $product->id)}}" method="post" style="display: inline-block">
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
                                {{ $products->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.includes.footer')
