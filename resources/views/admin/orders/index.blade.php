@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Filtrlər -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Sifarişləri Filtrlə</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('orders.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="status" class="form-control">
                                            <option value="">Status seçin</option>
                                            @foreach(\App\Enum\OrderStatus::cases() as $status)
                                                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                                    {{ \App\Enum\OrderStatus::label($status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="shop" class="form-control" placeholder="Mağaza" value="{{ request('shop') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="payment_type" class="form-control">
                                            <option value="">Ödəniş növü seçin</option>
                                            <option value="cash" {{ request('payment_type') == 'cash' ? 'selected' : '' }}>Nağd</option>
                                            <option value="online" {{ request('payment_type') == 'online' ? 'selected' : '' }}>Kart</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Filtrlə</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sifarişlər Cədvəli -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Sifarişlər</h5>
                        </div>
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-hover table-striped">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Sifariş nömrəsi</th>
                                        <th>Müştəri</th>
                                        <th>Status</th>
                                        <th>Çatdırılma</th>
                                        <th>Mağaza</th>
                                        <th>Ödəniş növü</th>
                                        <th>Məbləğ</th>
                                        <th>Endirim</th>
                                        <th>Çatdırılma məbləği</th>
                                        <th>Yekun</th>
                                        <th>Detallar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr class="{{ \App\Enum\OrderStatus::color($order->status) }}">
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->customer?->name }}</td>
                                            <td>{{ \App\Enum\OrderStatus::label($order->status) }}</td>
                                            <td>{{ $order->is_deliver ? 'Var' : 'Yox' }}</td>
                                            <td>{{ $order->shop }}</td>
                                            <td>{{ $order->payment_type }}</td>
                                            <td>{{ number_format($order->total_price, 2) }} ₼</td>
                                            <td>{{ $order->discount }}</td>
                                            <td>{{ $order->delivered_price }}</td>
                                            <td>{{ number_format($order->final_price, 2) }} ₼</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Bax
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.includes.footer')
