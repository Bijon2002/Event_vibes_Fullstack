<?php
header("Content-Type: application/json");

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Capture JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["message"])) {
    $user_input = $data["message"]; // Capture the message from user
} else {
    die(json_encode(["error" => "No message provided"]));
}

// Log user input (for debugging)
error_log("User Input: " . $user_input);

// Predefined responses based on the message
$predefined_responses = [
    "booking" => "Your booking has been confirmed. 🥳 You will receive further details shortly.",
    "cancel" => "Your booking has been successfully canceled. We're sorry to see you go! 😔",
    "hello" => "Hello! How can I assist you with your event today?",
    "thank you" => "You're welcome! Let us know if you need anything else. 😊",
    "bye" => "Goodbye! Have a great day! 👋",
];

// Match the user input to predefined responses
$response_message = "Sorry, I didn't quite catch that. Can you please clarify?";

// Check if the user's message matches any predefined responses
foreach ($predefined_responses as $keyword => $reply) {
    if (strpos(strtolower($user_input), $keyword) !== false) {
        $response_message = $reply;
        break;
    }
}

// Build the response structure
$response = [
    "choices" => [
        [
            "message" => [
                "content" => $response_message
            ]
        ]
    ]
];

// Log API response (for debugging)
error_log("API Response: " . json_encode($response));

// Output the response
echo json_encode($response);
?>
