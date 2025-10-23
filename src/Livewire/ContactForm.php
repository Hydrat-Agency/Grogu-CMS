<?php

namespace Hydrat\GroguCMS\Livewire;

use Exception;
use GrantHolle\Altcha\Rules\ValidAltcha;
use Hydrat\GroguCMS\Actions\Form as Actions;
use Hydrat\GroguCMS\Models\Form;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class ContactForm extends Component
{
    use WithFileUploads;

    #[Locked]
    public Form $form;

    public array $data = [];

    public string $altcha;

    public string $onSuccessMessage = '';

    public string $onErrorMessage = '';

    protected function rules()
    {
        return [
            ...Actions\GetFormValidationRules::run($this->form, prefixKey: 'data.'),
            'altcha' => ['required', new ValidAltcha],
        ];
    }

    protected function validationAttributes()
    {
        return Actions\GetFormValidationAttributes::run($this->form, prefixKey: 'data.');
    }

    public function submit()
    {
        $this->onSuccessMessage = '';
        $this->onErrorMessage = '';

        if (filled($this->rules())) {
            $this->validate();
        }

        $this->dispatch('form-validated', $this->form, $this->data);

        try {
            $formEntry = Actions\SubmitFormEntry::run($this->form, $this->data);
        } catch (Throwable|Exception $e) {
            report($e);
            $this->onErrorMessage = __('An error occurred while submitting the form. Please try again later.');
            $this->dispatch('form-submission-failed', $this->form, $this->data, $e);

            return;
        }

        $this->data = [];
        $this->onSuccessMessage = $this->form->translate('submit_success_message');

        $this->dispatch('form-submitted', $formEntry);
    }

    public function resetForm()
    {
        $this->onSuccessMessage = '';
        $this->onErrorMessage = '';
        $this->data = [];

        $this->dispatch('form-reseted');
    }

    public function render()
    {
        return view('grogu-cms::livewire.contact-form');
    }
}
