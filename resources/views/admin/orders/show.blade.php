@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Sifariş Başlığı -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Sifariş Detalları #{{ $order->order_number }}</h3>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Geri
                        </a>
                    </div>
                </div>
            </div>

            <!-- Müştəri Məlumatları və Sifariş Statusu -->
            <div class="row">
                <!-- Müştəri Məlumatları -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-user"></i> Müştəri Məlumatları
                        </div>
                        <div class="card-body">
                            <p><strong>Adı:</strong> {{ $order->customer?->name }}</p>
                            <p><strong>Ünvan:</strong> {{ $order->customer?->address?->address ?? 'Ünvan yoxdur' }}</p>
                            <p><strong>Əlavə Məlumat:</strong> {{ $order->customer?->address?->additional_info ?? 'Əlavə məlumat yoxdur' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Sifariş Statusu -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <i class="fas fa-tasks"></i> Sifariş Statusunu Dəyiş
                        </div>
                        <div class="card-body">
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-group">
                                    <select name="status" class="form-select">
                                        @foreach(\App\Enum\OrderStatus::cases() as $status)
                                            <option value="{{ $status->value }}" {{ $order->status === $status->value ? 'selected' : '' }}>
                                                {{ \App\Enum\OrderStatus::label($status->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Saxla
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Məhsullar Siyahısı -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <i class="fas fa-boxes"></i> Sifariş Məhsulları
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Şəkil</th>
                                        <th>Məhsul</th>
                                        <th>Miqdar</th>
                                        <th>Qiymət</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderItems as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $product->product?->image) }}"
                                                     alt="Məhsul Şəkli"
                                                     class="img-thumbnail"
                                                     style="width: 70px; height: 90px;">
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->product?->id) }}" class="text-decoration-none">
                                                    {{ $product->product?->title }}
                                                </a>
                                            </td>
                                            <td>{{ $product->quantity }}</td>

                                            <td>{{ number_format($product->price, 2) }} ₼</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <h5><strong>Yekun Məbləğ:</strong> {{ number_format($order->final_price, 2) }} ₼</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.includes.footer')
