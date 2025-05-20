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
                            <h4 class="card-title">{{$product->title}} haqqında verilən suallar</h4>
                            <a href="{{ route('products.product_faqs.create', $product->id) }}" class="btn btn-primary">+</a>
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
                                    @foreach($product_faqs as $product_faq)
                                        <tr>
                                            <th scope="row">{{ $product_faq->id }}</th>
                                            <th scope="row">{{ $product_faq->title }}</th>
                                            <td>{{ $product_faq->is_active ? 'Active' : 'Deactive' }}</td>
                                            <td>
                                                <a href="{{ route('products.product_faqs.edit', [$product->id, $product_faq->id]) }}"
                                                   class="btn btn-primary"
                                                   style="margin-right: 15px">Edit</a>
                                                <form action="{{ route('products.product_faqs.destroy', [$product->id, $product_faq->id]) }}"
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
                                {{ $product_faqs->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
