<div>
    <div class="row mb-4">
        <div class="col-md-6">
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search phones...">
        </div>
        <div class="col-md-6">
            <select wire:model="brand" class="form-control">
                <option value="">All Brands</option>
                @foreach($brands as $brandOption)
                    <option value="{{ $brandOption }}">{{ $brandOption }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        @forelse($phones as $phone)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($phone->image)
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            {{-- <span class="text-muted">No Image</span> --}}
                            <img src="https://static1.anpoimages.com/wordpress/wp-content/uploads/2024/11/android-how-to-clear-cache-new.jpg" alt="Phone">
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $phone->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $phone->brand }}</h6>
                        {{-- <p class="card-text">{{ \Illuminate\Support\Str::limit($phone->description, 100) }}</p> --}}
                        <p class="card-text"><strong>${{ number_format($phone->price, 2) }}</strong></p>
                        {{-- @if($phone->specifications)
                            <div class="mt-2">
                                <h6>Specifications:</h6>
                                <p>{{ $phone->specifications }}</p>
                            </div>
                        @endif --}}
                    </div>
                    <div class="card-footer">
                        <a href="{{ backpack_url('phones/' . $phone->id) }}" 
                          class="btn btn-primary">
                          View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No phones found.
                </div>
            </div>
        @endforelse
    </div>

    <div class="row">
        <div class="col-12">
            {{ $phones->links() }}
        </div>
    </div>
</div>