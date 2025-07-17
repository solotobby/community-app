<?php

namespace App\Livewire\Admin\Crowdfunding;

use Livewire\Component;
use App\Models\GiftReason as GiftReasons;
use Livewire\WithPagination;

class GiftReason extends Component
{
    use WithPagination;

    public $name = '';
    public $icon = '';
    public $status = true;
    public $showModal = false;
    public $giftReasonId = null;
    public $availableIcons = [
        'fa-gift', 'fa-heart', 'fa-star', 'fa-cake-candles', 'fa-hand-holding-heart',
        'fa-lightbulb', 'fa-graduation-cap', 'fa-hands', 'fa-glass-cheers', 'fa-church',
        'fa-briefcase', 'fa-shopping-bag', 'fa-seedling', 'fa-clock', 'fa-microphone',
        'fa-shirt', 'fa-calendar-alt', 'fa-trophy', 'fa-music', 'fa-camera',
        'fa-baby', 'fa-ring', 'fa-hospital', 'fa-people-arrows', 'fa-cross',
        'fa-house', 'fa-praying-hands', 'fa-party-horn', 'fa-face-grin-stars'
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'icon' => 'required|string|max:255',
        'status' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        GiftReasons::updateOrCreate(
            ['id' => $this->giftReasonId],
            [
                'reason' => $this->name,
                'icon' => $this->icon,
                'status' => $this->status
            ]
        );

        session()->flash('message', 'Gift reason saved successfully!');
        $this->resetForm();
        $this->showModal = false;
    }

    public function openModal()
{
    $this->resetForm();
    $this->showModal = true;
}

    public function edit($id)
    {
        $this->showModal = true;
        $reason = GiftReasons::findOrFail($id);
        $this->giftReasonId = $reason->id;
        $this->name = $reason->name;
        $this->icon = $reason->icon;
        $this->status = $reason->status;
    }

    public function delete($id)
    {
        GiftReasons::findOrFail($id)->delete();
        session()->flash('message', 'Gift reason deleted.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'icon', 'status', 'giftReasonId']);
    }

    public function render()
    {
        return view('livewire.admin.crowdfunding.gift-reason', [
            'reasons' => GiftReasons::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

}
