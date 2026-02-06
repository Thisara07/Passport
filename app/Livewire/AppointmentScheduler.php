<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\TimeSlot;
use App\Models\Applicant;
use Carbon\Carbon;

class AppointmentScheduler extends Component
{
    public $appointment_date;
    public $office_branch;
    public $appointment_time;
    public $nic_number;
    public $availableSlots = [];
    public $branches = ['Colombo', 'Kandy', 'Galle', 'Jaffna', 'Matara'];
    public $reschedule_id;
    
    protected $rules = [
        'appointment_date' => 'required|date|after:today',
        'office_branch' => 'required|in:Colombo,Kandy,Galle,Jaffna,Matara',
        'appointment_time' => 'required',
        'nic_number' => 'required|string|max:12',
    ];

    public function mount($reschedule_id = null)
    {
        if ($reschedule_id) {
            $appointment = Appointment::where('Appointment_ID', $reschedule_id)
                ->where('Applicant_ID', auth('web')->id())
                ->first();

            if ($appointment && $appointment->Status === 'PENDING') {
                $this->reschedule_id = $reschedule_id;
                $this->appointment_date = $appointment->Appointment_Date->format('Y-m-d');
                $this->office_branch = $appointment->Office_Branch;
                $this->nic_number = $appointment->NIC_Number;
                $this->loadAvailableSlots();
                return;
            }
        }

        $this->appointment_date = Carbon::tomorrow()->format('Y-m-d');
        $this->office_branch = 'Colombo';
        $this->loadAvailableSlots();
    }

    public function updated($property)
    {
        if (in_array($property, ['appointment_date', 'office_branch'])) {
            $this->loadAvailableSlots();
        }
    }

    public function loadAvailableSlots()
    {
        if (!$this->appointment_date || !$this->office_branch) {
            $this->availableSlots = collect();
            return;
        }

        $this->availableSlots = TimeSlot::where('Slot_Date', $this->appointment_date)
            ->where('Office_Branch', $this->office_branch)
            ->where('Status', 'ACTIVE')
            ->whereColumn('Current_Bookings', '<', 'Max_Capacity')
            ->get()
            ->map(function ($slot) {
                $available_capacity = $slot->Max_Capacity - $slot->Current_Bookings;
                return [
                    'Slot_ID' => $slot->Slot_ID,
                    'Start_Time' => $slot->Start_Time,
                    'End_Time' => $slot->End_Time,
                    'available_capacity' => $available_capacity,
                ];
            });
    }

    public function submit()
    {
        $this->validate();

        // Check if slot is still available
        $selectedSlot = TimeSlot::find($this->appointment_time);
        if (!$selectedSlot || $selectedSlot->Current_Bookings >= $selectedSlot->Max_Capacity) {
            $this->addError('appointment_time', __('messages.slot_no_longer_available'));
            return;
        }

        // Get the authenticated applicant
        $applicant = auth('web')->user();
        
        if ($this->reschedule_id) {
            $appointment = Appointment::where('Appointment_ID', $this->reschedule_id)
                ->where('Applicant_ID', $applicant->Applicant_ID)
                ->firstOrFail();
            
            // Decrement old slot bookings if it was different
            if ($appointment->Slot_ID != $this->appointment_time) {
                $oldSlot = TimeSlot::find($appointment->Slot_ID);
                if ($oldSlot) {
                    $oldSlot->decrement('Current_Bookings');
                }
                $selectedSlot->increment('Current_Bookings');
            }

            $appointment->update([
                'Slot_ID' => $this->appointment_time,
                'Appointment_Date' => $this->appointment_date,
                'Appointment_Time' => $selectedSlot->Start_Time,
                'NIC_Number' => $this->nic_number,
                'Office_Branch' => $this->office_branch,
            ]);

            session()->flash('success', __('messages.appointment_rescheduled_successfully'));
        } else {
            // Create new appointment
            $appointment = Appointment::create([
                'Applicant_ID' => $applicant->Applicant_ID,
                'Slot_ID' => $this->appointment_time,
                'Appointment_Date' => $this->appointment_date,
                'Appointment_Time' => $selectedSlot->Start_Time,
                'NIC_Number' => $this->nic_number,
                'Office_Branch' => $this->office_branch,
                'Status' => 'PENDING'
            ]);

            // Update slot booking count
            $selectedSlot->increment('Current_Bookings');
            session()->flash('success', __('messages.appointment_booked_successfully'));
        }

        // Generate QR code data (store in session for success page)
        session([
            'qr_appointment_id' => $appointment->Appointment_ID,
            'qr_user_name' => $applicant->Name,
            'qr_appointment_date' => $this->appointment_date,
            'qr_appointment_time' => $selectedSlot->Start_Time
        ]);

        return redirect()->route('appointment.success');
    }

    public function render()
    {
        return view('livewire.appointment-scheduler');
    }
}