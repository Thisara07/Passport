<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $reschedule_id = $request->get('reschedule_id');
        
        return view('appointment.form', compact('reschedule_id'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'NIC_number' => 'required|string|max:20',
            'office_branch' => 'required|string|max:100',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            // Check if slot is still available
            $isSlotAvailable = $this->checkSlotAvailability(
                $request->appointment_date,
                $request->appointment_time,
                $request->office_branch
            );
            
            if (!$isSlotAvailable) {
                return redirect()->back()
                    ->withErrors(['error' => 'Selected time slot is no longer available. Please select another time slot.'])
                    ->withInput();
            }
            
            // Create appointment
            $appointment = Appointment::create([
                'Applicant_ID' => Auth::id(),
                'Appointment_Date' => $request->appointment_date,
                'Appointment_Time' => $request->appointment_time,
                'NIC_Number' => $request->NIC_number,
                'Office_Branch' => $request->office_branch,
                'Status' => 'PENDING'
            ]);
            
            // Update slot booking count
            $this->updateSlotBookingCount(
                $request->appointment_date,
                $request->appointment_time,
                $request->office_branch
            );
            
            // Generate QR code data (store in session for success page)
            $user = Auth::user();
            session([
                'qr_appointment_id' => $appointment->Appointment_ID,
                'qr_user_name' => $user->Name,
                'qr_appointment_date' => $request->appointment_date,
                'qr_appointment_time' => $request->appointment_time
            ]);
            
            return redirect()->route('appointment.success')
                ->with('success', __('messages.appointment_booked_successfully'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to book appointment: ' . $e->getMessage()])
                ->withInput();
        }
    }
    
    public function success()
    {
        $qrData = [
            'appointment_id' => session('qr_appointment_id'),
            'user_name' => session('qr_user_name'),
            'appointment_date' => session('qr_appointment_date'),
            'appointment_time' => session('qr_appointment_time')
        ];
        
        return view('appointment.success', compact('qrData'));
    }
    
    public function cancel($id)
    {
        $appointment = Appointment::where('Appointment_ID', $id)
            ->where('Applicant_ID', Auth::id())
            ->firstOrFail();

        if ($appointment->Status !== 'PENDING') {
            return redirect()->back()->with('error', 'Only pending appointments can be cancelled.');
        }

        $appointment->delete();

        return redirect()->back()->with('success', __('messages.appointment_deleted_successfully'));
    }

    public function view()
    {
        $applicant = Auth::user();
        $appointments = $applicant->appointments()->orderBy('Appointment_Date', 'desc')->get();
        
        return view('appointment.view', compact('appointments'));
    }
    
    // Helper methods
    private function getAvailableTimeSlots($date, $branch)
    {
        // Query the actual time_slots table
        $timeSlots = DB::table('time_slots')
            ->where('Slot_Date', $date)
            ->where('Office_Branch', $branch)
            ->where('Status', 'ACTIVE')
            ->whereColumn('Current_Bookings', '<', 'Max_Capacity')
            ->select('Start_Time', 'End_Time', 'Max_Capacity', 'Current_Bookings')
            ->orderBy('Start_Time')
            ->get();
            
        return $timeSlots->map(function ($slot) {
            return [
                'Start_Time' => $slot->Start_Time,
                'End_Time' => $slot->End_Time,
                'available_capacity' => $slot->Max_Capacity - $slot->Current_Bookings
            ];
        });
    }
    
    private function checkSlotAvailability($date, $time, $branch)
    {
        $availableSlots = $this->getAvailableTimeSlots($date, $branch);
        return $availableSlots->contains(function ($slot) use ($time) {
            return $slot['Start_Time'] === $time && $slot['available_capacity'] > 0;
        });
    }
    
    private function updateSlotBookingCount($date, $time, $branch)
    {
        // In a real implementation, this would update the time_slots table
        // For now, this is a placeholder
        return true;
    }
}
