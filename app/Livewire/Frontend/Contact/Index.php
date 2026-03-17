<?php

namespace App\Livewire\Frontend\Contact;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;

class Index extends Component
{
    // Properties for form fields
    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $phone = '';

    #[Validate('required|min:5')]
    public $subject = '';

    #[Validate('required|min:10')]
    public $message = '';


    public function mount()
    {
        // This is where you'd normally fetch your settings from the DB
        // $this->settings = \App\Models\Setting::first()->toArray();
    }

    public function sendMessage()
    {
        $validated = $this->validate();

        try {
            // Send Email logic
            Mail::raw("Name: {$this->name}\nPhone: {$this->phone}\nMessage: {$this->message}", function ($message) {
                $message->to($this->settings['email'])
                    ->from($this->email, $this->name)
                    ->subject("Contact Form: " . $this->subject);
            });

            // Reset form fields
            $this->reset(['name', 'email', 'phone', 'subject', 'message']);

            // Show success message
            session()->flash('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.contact.index');
    }
}
