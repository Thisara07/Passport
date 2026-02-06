<?php

namespace App\Models;

class Chatbot
{
    /**
     * Get a response for the given message using rule-based logic
     *
     * @param string $message
     * @return string
     */
    public function getResponse($message)
    {
        $message = strtolower(trim($message));

        // Greeting responses
        if (strpos($message, "hello") !== false || strpos($message, "hi") !== false) {
            return "Hello! I'm your passport assistant. How can I help you with your passport application or appointment?";
        }

        // Appointment related
        if (strpos($message, "book") !== false || strpos($message, "appointment") !== false) {
            return "To book an appointment, please go to the 'Appointment' section in the navigation menu. You can select a date and time that works for you.";
        }

        // Status check
        if (strpos($message, "status") !== false) {
            return "You can check your application status from your dashboard after logging in. Go to 'Dashboard' to view all your applications and their current status.";
        }

        // Documents and requirements
        if (strpos($message, "documents") !== false || strpos($message, "requirements") !== false) {
            return "For a new passport, you'll need: Your NIC, birth certificate, and a recent passport-sized photo. For renewal: Your current passport and a new photo. Visit our 'Instructions' page for detailed requirements.";
        }

        // Office hours
        if (strpos($message, "hours") !== false || strpos($message, "timing") !== false) {
            return "Our office hours are 8:00 AM to 4:00 PM, Monday to Friday. Appointments can be booked online 24/7.";
        }

        // Fees and costs
        if (strpos($message, "fee") !== false || strpos($message, "cost") !== false || strpos($message, "price") !== false) {
            return "Fees vary based on passport type and processing time. A standard 32-page passport costs Rs. 5,000, while an urgent processing fee is Rs. 15,000. Check our 'Instructions' page for the complete fee structure.";
        }

        // Renewal
        if (strpos($message, "renew") !== false) {
            return "You can renew your passport up to 1 year before expiration. Visit the 'Application' section and select 'Renewal' as your application type.";
        }

        // Lost or stolen passport
        if (strpos($message, "lost") !== false || strpos($message, "stolen") !== false) {
            return "If your passport is lost or stolen, you'll need to file a police report first, then apply for a replacement. Visit our 'Application' section and select 'Replacement' as your type.";
        }

        // Processing time
        if (strpos($message, "processing") !== false || strpos($message, "how long") !== false || strpos($message, "time") !== false) {
            return "Standard processing takes 15 working days. Express service (additional fee) takes 5 working days. You can track your application status from your dashboard.";
        }

        // Photo requirements
        if (strpos($message, "photo") !== false) {
            return "Your passport photo must be 35mm x 45mm, taken against a white background, and captured within the last 6 months. The face must be clearly visible without shadows.";
        }

        // Child passport
        if (strpos($message, "child") !== false || strpos($message, "minor") !== false || strpos($message, "baby") !== false) {
            return "For children under 16, both parents must accompany them during the application process. You'll need the child's birth certificate and both parents' NICs.";
        }

        // Contact information
        if (strpos($message, "contact") !== false || strpos($message, "phone") !== false || strpos($message, "email") !== false) {
            return "You can reach us at +94 11 234 5678 or email us at info@passport.gov.lk. For more contact options, visit our 'Contact' page.";
        }

        // Application process
        if (strpos($message, "apply") !== false || strpos($message, "application") !== false || strpos($message, "new passport") !== false) {
            return "To apply for a new passport: 1) Register/Login to your account, 2) Fill out the Application form, 3) Book an appointment, 4) Visit our office with required documents. Start by clicking 'Application' in the menu.";
        }

        // Thanks
        if (strpos($message, "thank") !== false) {
            return "You're welcome! Is there anything else I can assist you with regarding your passport?";
        }

        // Help
        if (strpos($message, "help") !== false) {
            return "I can help you with: \n• Booking appointments\n• Application requirements\n• Document requirements\n• Fees and costs\n• Processing times\n• Lost/stolen passports\n• Child passports\n• Contact information\n\nJust ask about any of these topics!";
        }

        // Default fallback response
        return "I'm here to help with passport-related questions. You can ask about appointments, required documents, fees, processing times, and more. Type 'help' to see all topics I can assist with!";
    }
}
