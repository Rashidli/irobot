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
                            <h4 class="card-title">Müştərilər</h4>
                            <br>

                            <!-- Search Form -->
                            <form method="GET" action="{{ route('customers.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="name" class="form-control" placeholder="Ad üzrə axtar"
                                               value="{{ request('name') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="email" class="form-control"
                                               placeholder="Email üzrə axtar" value="{{ request('email') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="phone" class="form-control"
                                               placeholder="Telefon üzrə axtar" value="{{ request('phone') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">Axtar</button>
                                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Sıfırla</a>
                                    </div>
                                </div>
                            </form>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Ad</th>
                                        <th>Telefon</th>
                                        <th>Email</th>
                                        <th>Səbəti</th>
                                        <th>Favoritləri</th>
{{--                                        <th>Əməliyyat</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <th scope="row">{{ $customer->id }}</th>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>
                                                <a href="{{ route('customer_basket', $customer->id) }}" class="btn btn-primary">{{$customer->basket_items_count}} Məhsul</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('favorites.index', $customer->id) }}" class="btn btn-primary">{{$customer->favorites_count}} Məhsul</a>
                                            </td>
{{--                                            <td>--}}
{{--                                                <form action="{{ route('customer.toggleStatus', $customer->id) }}"--}}
{{--                                                      method="post" style="display: inline-block">--}}
{{--                                                    @csrf--}}

{{--                                                    @if($customer->is_blocked)--}}

{{--                                                        <button class="btn btn-success">--}}
{{--                                                            Blokdan çıxart--}}
{{--                                                        </button>--}}
{{--                                                    @else--}}
{{--                                                        <button--}}
{{--                                                            type="submit" class="btn btn-danger">--}}
{{--                                                            Blokla--}}
{{--                                                        </button>--}}
{{--                                                    @endif--}}


{{--                                                </form>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $customers->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')

