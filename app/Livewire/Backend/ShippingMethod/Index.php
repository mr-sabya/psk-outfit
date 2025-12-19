<?php

namespace App\Livewire\Backend\ShippingMethod;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Livewire\Component;
use App\Models\ShippingRule;
use Livewire\WithPagination;
use App\Models\ShippingMethod;
use Livewire\WithoutUrlPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    // Table Controls
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $statusFilter = '';
    public $perPage = 10;

    // Method Form Properties
    public $method_id, $name, $is_default = false, $status = true;
    
    // Rule Form Properties
    public $rule_id, $selected_method_id;
    public $country_id, $state_id, $city_id, $cost;
    public $states = [], $cities = [];

    // UI States
    public $showMethodModal = false;
    public $showRuleModal = false;

    protected $queryString = ['search', 'statusFilter', 'sortField', 'sortDirection'];

    public function updatingSearch() { $this->resetPage(); }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // --- Shipping Method Logic ---

    public function openMethodModal($id = null)
    {
        $this->resetValidation();
        $this->method_id = $id;
        if ($id) {
            $method = ShippingMethod::findOrFail($id);
            $this->name = $method->name;
            $this->is_default = $method->is_default;
            $this->status = $method->status;
        } else {
            $this->reset(['name', 'is_default', 'status']);
        }
        $this->showMethodModal = true;
    }

    public function saveMethod()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
            'is_default' => 'boolean'
        ]);

        if ($this->is_default) {
            ShippingMethod::where('is_default', true)->update(['is_default' => false]);
        }

        ShippingMethod::updateOrCreate(
            ['id' => $this->method_id],
            [
                'name' => $this->name,
                'slug' => \Str::slug($this->name),
                'is_default' => $this->is_default,
                'status' => $this->status,
            ]
        );

        $this->showMethodModal = false;
        session()->flash('message', 'Shipping Method Saved.');
    }

    public function toggleStatus($id)
    {
        $method = ShippingMethod::findOrFail($id);
        $method->update(['status' => !$method->status]);
    }

    // --- Shipping Rules Logic ---

    public function openRuleModal($methodId, $ruleId = null)
    {
        $this->resetValidation();
        $this->selected_method_id = $methodId;
        $this->rule_id = $ruleId;
        
        if ($ruleId) {
            $rule = ShippingRule::findOrFail($ruleId);
            $this->country_id = $rule->country_id;
            $this->state_id = $rule->state_id;
            $this->city_id = $rule->city_id;
            $this->cost = $rule->cost;
            $this->updatedCountryId($this->country_id);
            $this->updatedStateId($this->state_id);
        } else {
            $this->reset(['country_id', 'state_id', 'city_id', 'cost']);
        }
        $this->showRuleModal = true;
    }

    public function updatedCountryId($id)
    {
        $this->states = State::where('country_id', $id)->get();
        $this->cities = [];
        $this->state_id = null;
        $this->city_id = null;
    }

    public function updatedStateId($id)
    {
        $this->cities = City::where('state_id', $id)->get();
        $this->city_id = null;
    }

    public function saveRule()
    {
        $this->validate([
            'country_id' => 'required',
            'cost' => 'required|numeric|min:0',
        ]);

        ShippingRule::updateOrCreate(
            ['id' => $this->rule_id],
            [
                'shipping_method_id' => $this->selected_method_id,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'city_id' => $this->city_id,
                'cost' => $this->cost,
            ]
        );

        $this->showRuleModal = false;
        session()->flash('message', 'Shipping Rule Saved.');
    }

    public function deleteRule($id)
    {
        ShippingRule::find($id)->delete();
    }

    public function render()
    {
        $methods = ShippingMethod::with('rules.city', 'rules.state', 'rules.country')
            ->where('name', 'like', '%' . $this->search . '%')
            ->when($this->statusFilter !== '', function($q) {
                return $q->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.shipping-method.index', [
            'methods' => $methods,
            'countries' => Country::all()
        ]);
    }
}
