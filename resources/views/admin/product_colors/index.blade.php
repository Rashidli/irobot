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
                            <h4 class="card-title">{{$product->title}} Rəngləri</h4>
                            <a href="{{ route('products.product_colors.create', $product->id) }}" class="btn btn-primary">+</a>
                            <br><br>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>

                                    <tr>
                                        <th>№</th>
                                        <th>Rəng</th>
                                        <th>Default</th>
                                        <th>Status</th>
                                        <th>Əməliyyat</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($product_colors as $product_color)
                                        <tr>
                                            <th scope="row">{{ $product_color->id }}</th>
                                            <th scope="row">{{ $product_color->title }}</th>
                                            <th scope="row">{{ $product_color->is_default ? 'Yes' : 'No' }}</th>
                                            <td>{{ $product_color->is_active ? 'Active' : 'Deactive' }}</td>
                                            <td>
                                                <a href="{{ route('products.product_colors.edit', [$product->id, $product_color->id]) }}"
                                                   class="btn btn-primary"
                                                   style="margin-right: 15px">Edit</a>
                                                <form action="{{ route('products.product_colors.destroy', [$product->id, $product_color->id]) }}"
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
                                {{ $product_colors->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
