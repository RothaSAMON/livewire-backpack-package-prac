@extends(backpack_view('blank'))

@section('content')
    <div class="container-fluid">
        <h1>Phone Catalog</h1>
        <div class="row">
            <div class="col-md-12">
                @livewire('phone-catalog')
            </div>
        </div>
    </div>
@endsection