@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                            <h4 class="card-title">{{$product->title}} detalları</h4>
                            <a href="{{ route('products.product_details.create', $product->id) }}" class="btn btn-primary">+</a>
                            <br><br>
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
                                    @foreach($product_details as $product_detail)
                                        <tr>
                                            <th scope="row">{{ $product_detail->id }}</th>
                                            <th scope="row">{{ $product_detail->title }}</th>
                                            <td>{{ $product_detail->is_active ? 'Active' : 'Deactive' }}</td>
                                            <td>
                                                <a href="{{ route('products.product_details.edit', [$product->id, $product_detail->id]) }}"
                                                   class="btn btn-primary"
                                                   style="margin-right: 15px">Edit</a>
                                                <form action="{{ route('products.product_details.destroy', [$product->id, $product_detail->id]) }}"
                                                      method="post"
                                                      style="display: inline-block">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')"
                                                            type="submit"
                                                            class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $product_details->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
