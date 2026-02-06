<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Application;
use App\Models\Applicant;
use App\Models\Document;

class ApplicationForm extends Component
{
    use WithFileUploads;

    public $full_name;
    public $gender;
    public $dob;
    public $phone;
    public $address;
    public $street;
    public $city;
    public $province;
    public $nic_number;
    public $nic_file;
    public $birth_file;
    public $photo_file;

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'gender' => 'required|in:Male,Female,Other',
        'dob' => 'required|date',
        'phone' => 'required|string|max:20',
        'nic_number' => 'required|string|max:12',
        'address' => 'required|string|max:255',
        'street' => 'required|string|max:100',
        'city' => 'required|string|max:100',
        'province' => 'required|string|max:100',
        'nic_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'birth_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'photo_file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
    ];

    public function submit()
    {
        $this->validate();

        // Get the authenticated applicant
        $applicant = auth('web')->user();
        
        try {
            // Save files - standardizing to documents folder
            $nicPath = $this->nic_file->store('documents', 'public');
            $birthPath = $this->birth_file->store('documents', 'public');
            $photoPath = $this->photo_file->store('documents', 'public');

            // Create Document record
            $document = Document::create([
                'NIC_card' => $nicPath,
                'Birth_Certificate' => $birthPath,
                'Photo' => $photoPath,
                'verification_status' => 'PENDING'
            ]);

            // Create Application record
            Application::create([
                'Applicant_ID' => $applicant->Applicant_ID,
                'Document_ID' => $document->Document_ID,
                'Full_Name' => $this->full_name,
                'Gender' => $this->gender,
                'Date_of_Birth' => $this->dob,
                'Phone_Number' => $this->phone,
                'NIC' => $this->nic_number,
                'Address' => $this->address,
                'Street' => $this->street,
                'City' => $this->city,
                'Province' => $this->province,
                'Status' => 'PENDING',
            ]);

            session()->flash('success', __('messages.application_submitted_successfully'));
            return redirect()->route('application.success');

        } catch (\Exception $e) {
            session()->flash('error', 'Error submitting application: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.application-form');
    }
}