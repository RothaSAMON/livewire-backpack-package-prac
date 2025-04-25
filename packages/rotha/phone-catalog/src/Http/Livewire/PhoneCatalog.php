<?php

namespace Rotha\PhoneCatalog\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Rotha\PhoneCatalog\Models\Phone;

class PhoneCatalog extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    public $search = '';
    public $brand = '';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingBrand()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $phones = Phone::query();
        
        if ($this->search) {
            $phones->where('name', 'like', '%' . $this->search . '%');
        }
        
        if ($this->brand) {
            $phones->where('brand', $this->brand);
        }
        
        $brands = Phone::select('brand')->distinct()->pluck('brand');
        
        return view('phone-catalog::livewire.phone-catalog', [
            'phones' => $phones->paginate(12),
            'brands' => $brands,
        ]);
    }
}