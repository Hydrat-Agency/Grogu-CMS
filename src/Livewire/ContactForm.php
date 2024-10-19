<?php

namespace Hydrat\GroguCMS\Livewire;

use Hydrat\GroguCMS\Actions\Form as Actions;
use Hydrat\GroguCMS\Models\Form;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ContactForm extends Component
{
    #[Locked]
    public Form $form;

    public array $data = [];

    public function submit()
    {
        $this->validate(
            rules: Actions\GetFormValidationRules::run($this->form, prefixKey: 'data.'),
            attributes: Actions\GetFormValidationAttributes::run($this->form, prefixKey: 'data.'),
        );

        $this->dispatch('form-validated');

        Actions\SubmitFormEntry::run($this->form, $this->data);

        $this->data = [];

        // add success message from form settings ?

        $this->dispatch('form-submitted');
    }

    public function render()
    {
        return view('grogu-cms::livewire.contact-form');
    }
}
