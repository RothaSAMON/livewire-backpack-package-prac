@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $phone->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($phone->image)
                                <img src="{{ asset('storage/' . $phone->image) }}" class="img-fluid" alt="{{ $phone->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                                    {{-- <span class="text-muted">No Image</span> --}}
                                    <img src="https://static1.anpoimages.com/wordpress/wp-content/uploads/2024/11/android-how-to-clear-cache-new.jpg" alt="Phone">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4>Brand: {{ $phone->brand }}</h4>
                            <h5>Price: ${{ number_format($phone->price, 2) }}</h5>
                            
                            <div class="mt-4">
                                <h5>Description:</h5>
                                <p>{{ $phone->description }}</p>
                            </div>

                            @if($phone->specifications)
                                <div class="mt-4">
                                    <h5>Specifications:</h5>
                                    <p>{{ $phone->specifications }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('phones.index') }}" class="btn btn-secondary">Back to Catalog</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection