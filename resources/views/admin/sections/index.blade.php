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
                                <h4 class="card-title">Sections</h4>
                                    <a href="{{route('sections.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Section</th>
                                                <th>Title</th>
{{--                                                <th>Status</th>--}}
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($sections as $section)

                                            <tr>
                                                <th scope="row">{{$section->id}}</th>
                                                <th scope="row">{{$section->type}}</th>
                                                <th scope="row">{{$section->title}}</th>
{{--                                                <td><img src="{{asset('storage/'.$section->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
{{--                                                <td>{{$section->is_active ? 'Active' : 'Deactive'}}</td>--}}
                                                <td>
                                                    <a href="{{route('sections.edit',$section->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                    <form action="{{route('sections.destroy', $section->id)}}" method="post" style="display: inline-block">
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
                                    {{ $sections->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
