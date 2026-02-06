<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index()
    {
        // Get all appointments with applicant details
        $appointments = Appointment::with('applicant')
            ->orderBy('Appointment_Date', 'desc')
            ->orderBy('Appointment_Time', 'desc')
            ->get();
            
        // Get time slots
        $timeSlots = TimeSlot::where('Status', 'ACTIVE')
            ->orderBy('Slot_Date')
            ->orderBy('Start_Time')
            ->get();
            
        return view('admin.appointments.index', compact('appointments', 'timeSlots'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:APPROVED,CANCELLED',
            'cancel_reason' => 'required_if:status,CANCELLED|max:255'
        ]);
        
        $appointment = Appointment::findOrFail($id);
        $appointment->Status = $request->status;
        
        if ($request->status === 'CANCELLED') {
            $appointment->Cancel_Reason = $request->cancel_reason;
        }
        
        $appointment->save();
        
        return redirect()->back()
            ->with('success', 'Appointment status updated successfully');
    }
    
    public function createTimeSlot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slot_date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'office_branch' => 'required|array|min:1',
            'office_branch.*' => 'string|max:100',
            'max_capacity' => 'required|integer|min:1|max:100'
        ], [
            'office_branch.required' => 'Please select at least one branch',
            'office_branch.array' => 'Branch selection must be an array',
            'office_branch.min' => 'Please select at least one branch'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $createdSlots = 0;
            $branches = $request->office_branch;
            
            foreach ($branches as $branch) {
                $timeSlot = TimeSlot::create([
                    'Slot_Date' => $request->slot_date,
                    'Start_Time' => $request->start_time,
                    'End_Time' => $request->end_time,
                    'Office_Branch' => $branch,
                    'Max_Capacity' => $request->max_capacity,
                    'Current_Bookings' => 0,
                    'Status' => 'ACTIVE'
                ]);
                
                if ($timeSlot) {
                    $createdSlots++;
                }
            }
            
            $message = $createdSlots > 1 
                ? "Successfully created {$createdSlots} time slots for " . implode(', ', $branches)
                : "Time slot created successfully for {$branches[0]}";
            
            return redirect()->back()
                ->with('success', $message);
                
        } catch (\Exception $e) {
            \Log::error('Time slot creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create time slot: ' . $e->getMessage()])
                ->withInput();
        }
    }
    
    public function deleteTimeSlot($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        
        // Check if slot has bookings
        if ($timeSlot->Current_Bookings > 0) {
            return redirect()->back()
                ->withErrors(['error' => 'Cannot delete slot with existing bookings']);
        }
        
        $timeSlot->delete();
        
        return redirect()->back()
            ->with('success', 'Time slot deleted successfully');
    }
    
    public function generateBulkSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'daily_start_time' => 'required',
            'daily_end_time' => 'required|after:daily_start_time',
            'interval_minutes' => 'required|integer|in:15,30,60',
            'office_branch' => 'required|array|min:1',
            'office_branch.*' => 'string|max:100',
            'max_capacity' => 'required|integer|min:1|max:50',
            'weekdays_only' => 'nullable|boolean'
        ], [
            'office_branch.required' => 'Please select at least one branch',
            'office_branch.array' => 'Branch selection must be an array',
            'office_branch.min' => 'Please select at least one branch'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $startDate = new \DateTime($request->start_date);
            $endDate = new \DateTime($request->end_date);
            $intervalMinutes = $request->interval_minutes;
            $branches = $request->office_branch;
            $weekdaysOnly = $request->has('weekdays_only');
            
            $createdCount = 0;
            $skippedDates = [];
            
            // Generate slots for each day in the range
            for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                // Skip weekends if weekdays_only is selected
                if ($weekdaysOnly && ($date->format('N') >= 6)) { // 6 = Saturday, 7 = Sunday
                    continue;
                }
                
                $currentDate = $date->format('Y-m-d');
                
                foreach ($branches as $branch) {
                    // Check if slots already exist for this date and branch
                    $existingSlots = TimeSlot::where('Slot_Date', $currentDate)
                        ->where('Office_Branch', $branch)
                        ->count();
                    
                    if ($existingSlots > 0) {
                        $skippedDates[] = $currentDate . ' (' . $branch . ')';
                        continue;
                    }
                    
                    // Generate time slots for the day
                    $dayStartTime = new \DateTime($currentDate . ' ' . $request->daily_start_time);
                    $dayEndTime = new \DateTime($currentDate . ' ' . $request->daily_end_time);
                    
                    $currentTime = clone $dayStartTime;
                    
                    while ($currentTime < $dayEndTime) {
                        $slotEndTime = clone $currentTime;
                        $slotEndTime->modify('+' . $intervalMinutes . ' minutes');
                        
                        // Ensure we don't go beyond end time
                        if ($slotEndTime > $dayEndTime) {
                            break;
                        }
                        
                        TimeSlot::create([
                            'Slot_Date' => $currentDate,
                            'Start_Time' => $currentTime->format('H:i:s'),
                            'End_Time' => $slotEndTime->format('H:i:s'),
                            'Office_Branch' => $branch,
                            'Max_Capacity' => $request->max_capacity,
                            'Current_Bookings' => 0,
                            'Status' => 'ACTIVE'
                        ]);
                        
                        $createdCount++;
                        $currentTime = $slotEndTime;
                    }
                }
            }
            
            $message = "Successfully created {$createdCount} time slots for " . implode(', ', $branches);
            if (!empty($skippedDates)) {
                $message .= ". Skipped dates with existing slots: " . implode(', ', array_slice($skippedDates, 0, 3));
                if (count($skippedDates) > 3) {
                    $message .= " and " . (count($skippedDates) - 3) . " more";
                }
            }
            
            return redirect()->back()
                ->with('success', $message);
                
        } catch (\Exception $e) {
            Log::error('Bulk time slot generation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to generate time slots: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
