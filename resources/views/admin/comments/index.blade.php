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
                            <h4 class="card-title">Rəylər</h4>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                    <thead>
                                    <tr>
                                        <th>İstifadəçi</th>
                                        <th>Məhsul</th>
                                        <th>Ulduz</th>
                                        <th>Rəy</th>
                                        <th>Əməliyat</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($comments as $key => $comment)

                                        <tr>
                                            <td>{{$comment->customer?->name}}</td>
                                            <td>
                                                <a href="{{route('products.edit', $comment->product?->id)}}">
                                                    <p>{{$comment->product?->code}}</p>
                                                    <img src="{{asset('storage/'.$comment->product?->image)}}"
                                                         style="width: 70px; height: 90px" alt="">
                                                    <p>{{$comment->product?->title}}</p>
                                                </a>
                                            </td>
                                            <td>
                                                @php
                                                    $fullStars = floor($comment->star);
                                                @endphp

                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="fa fa-star text-warning"></i>
                                                @endfor
                                            </td>
                                            <td>
                                                {{$comment->comment}}
                                            </td>
                                            <td>
                                                <form action="{{route('comments.update', $comment->id)}}" method="post">
                                                    {{ method_field('PUT') }}
                                                    @csrf

                                                    @if($comment->is_accept)
                                                        <button class="btn btn-info">
                                                            Rədd et
                                                        </button>
                                                    @else
                                                        <button class="btn btn-success">
                                                            Qəbul et
                                                        </button>
                                                    @endif


                                                </form>
                                            </td>


                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                                <br>
                                {{ $comments->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.includes.footer')
