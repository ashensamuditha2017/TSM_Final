<?php

// app/Http/Controllers/GoogleDataController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Gmail;
use Google\Service\Tasks;
use Illuminate\Support\Facades\Log;

class GoogleDataController extends Controller
{
    private function getClient()
    {
        $user = Auth::user();
        Log::info('User has access token: ' . ($user->google_access_token ? 'Yes' : 'No'));
        Log::info('User has refresh token: ' . ($user->google_refresh_token ? 'Yes' : 'No'));

        if (!$user->google_access_token || !$user->google_refresh_token) {
            return null;
        }

        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setAccessToken($user->google_access_token);

        // Check if the access token has expired and refresh it
        if ($client->isAccessTokenExpired()) {
            try {
                $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                $newAccessToken = $client->getAccessToken();
                $user->google_access_token = $newAccessToken;
                $user->save();
            } catch (\Exception $e) {
                Log::error('Failed to refresh Google access token: ' . $e->getMessage());
                return null; // Handle re-authentication
            }
        }

        return $client;
    }

    public function showCalendar()
    {
        $client = $this->getClient();
        if (!$client) {
            return redirect()->route('login')->withErrors(['error' => 'Please re-authenticate with Google.']);
        }

        $service = new Calendar($client);
        $calendarId = 'primary';
        $params = [
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'), // Only show upcoming events
        ];

        $events = [];
        try {
            $results = $service->events->listEvents($calendarId, $params);
            $events = $results->getItems();
        } catch (\Exception $e) {
            Log::error('Failed to fetch Google Calendar events: ' . $e->getMessage());
        }

        return view('google.calendar', compact('events'));
    }

    public function showEmails()
    {
        $client = $this->getClient();
        if (!$client) {
            return redirect()->route('login')->withErrors(['error' => 'Please re-authenticate with Google.']);
        }

        $service = new Gmail($client);
        $userEmail = 'me';
        $messages = [];
        try {
            $results = $service->users_messages->listUsersMessages($userEmail, ['maxResults' => 10]);
            foreach ($results->getMessages() as $message) {
                $msg = $service->users_messages->get($userEmail, $message->getId());
                $headers = $msg->getPayload()->getHeaders();
                $email = [
                    'id' => $msg->getId(),
                    'snippet' => $msg->getSnippet(),
                    'from' => 'Unknown',
                    'subject' => 'No Subject',
                ];
                foreach ($headers as $header) {
                    if ($header->getName() === 'From') {
                        $email['from'] = $header->getValue();
                    }
                    if ($header->getName() === 'Subject') {
                        $email['subject'] = $header->getValue();
                    }
                }
                $messages[] = $email;
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch Google emails: ' . $e->getMessage());
        }

        return view('google.email', compact('messages'));
    }

    public function showToDos()
    {
        $client = $this->getClient();
        if (!$client) {
            return redirect()->route('login')->withErrors(['error' => 'Please re-authenticate with Google.']);
        }

        $service = new Tasks($client);
        $tasklists = [];
        $tasks = [];
        try {
            $results = $service->tasklists->listTasklists();
            $tasklists = $results->getItems();
            if (!empty($tasklists)) {
                $tasksResults = $service->tasks->listTasks($tasklists[0]->getId(), ['maxResults' => 10]);
                $tasks = $tasksResults->getItems();
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch Google To-Dos: ' . $e->getMessage());
        }

        return view('google.todos', compact('tasks'));
    }
}