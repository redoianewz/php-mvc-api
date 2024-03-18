<?php

use MVC\Controller;

class ControllersHome extends Controller
{
    public function index()
    {
        // Connect to the model
        $model = $this->model('home');

        // Retrieve all users
        $users = $model->getAllUser();

        // Set HTTP status code and content
        $this->response->sendStatus(200);
        $this->response->setContent($users);
    }

    public function getUser($userId)
    {
        $model = $this->model('home');
        $user = $model->getUserById(intval($userId['id']));
        if (!$user) {
            $this->response->sendStatus(404);
            $this->response->setContent(['error' => 'User not found']);
            return;
        }
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'family' => $user['family'],
            'age' => $user['age'],
            'country' => $user['country'],
            'city' => $user['city']
        ];
        $this->response->sendStatus(200);
        $this->response->setContent($data);
    }


    public function createUser()
    {
        $model = $this->model('home');     
        $errors = [];   
        $errors = [];

        $fields = [
            'name' => ['string', 'Name'],
            'family' => ['string', 'Family'],
            'age' => ['integer', 'Age'],
            'country' => ['string', 'Country'],
            'city' => ['string', 'City']
        ];

        foreach ($fields as $field => [$expectedType, $fieldName]) {
            $value = $this->request->getPost($field);
            $error =$this->request->validateField($value, $expectedType, $fieldName);
            if ($error !== null) {
                $errors[] = $error;
            }
        }

    
        if (!empty($errors)) {
            $this->response->sendStatus(400);
            $this->response->setContent(['errors' => $errors]);
            return;
        }
       
        $userData = [
            'name' => htmlspecialchars($this->request->getPost('name')),
            'family' => htmlspecialchars($this->request->getPost('family')),
            'age' => intval($this->request->getPost('age')),
            'country' => htmlspecialchars($this->request->getPost('country')),
            'city' => htmlspecialchars($this->request->getPost('city'))
        ];
    
        $userId = $model->insertUser($userData);
        $this->response->sendStatus(200);
        $this->response->setContent(['data inserted successfully']);
    }

    public function updateUser($userId)
    {
        // Connect to the model
        $model = $this->model('home');

        $errors = [];

        // Define the fields along with their expected types
        $fields = [
            'name' => ['string', 'Name'],
            'family' => ['string', 'Family'],
            'age' => ['integer', 'Age'],
            'country' => ['string', 'Country'],
            'city' => ['string', 'City']
        ];

        // Validate fields
        foreach ($fields as $field => [$expectedType, $fieldName]) {
            $value = $this->request->getPost($field);
            $error = $this->request->validateField($value, $expectedType, $fieldName);
            if ($error !== null) {
                $errors[] = $error;
            }
        }
        $userIdValue = intval($userId['id'] ?? null);

        if ($userIdValue === 0) {
            $this->response->sendStatus(400);
            $this->response->setContent(['errors' => ['Invalid user ID']]);
            return;
        }
        // If there are any errors, send a 400 Bad Request response with all errors
        if (!empty($errors)) {
            $this->response->sendStatus(400);
            $this->response->setContent(['errors' => $errors]);
            return;
        }

        // Prepare user data
        $userData = [
            'name' => htmlspecialchars($this->request->getPost('name')),
            'family' => htmlspecialchars($this->request->getPost('family')),
            'age' => intval($this->request->getPost('age')),
            'country' => htmlspecialchars($this->request->getPost('country')),
            'city' => htmlspecialchars($this->request->getPost('city'))
        ];

        // Update user
        $success = $model->updateUser($userIdValue, $userData);

        // Set HTTP status code and content
        $this->response->sendStatus(200);
        $this->response->setContent(['success' => $success]);
    }


    public function deleteUser($userId)
    {
        // Connect to the model
        $model = $this->model('home');

        // Delete user
        $success = $model->deleteUser(intval($userId['id']));

        // Set HTTP status code and content
        $this->response->sendStatus(200);
        $this->response->setContent(['success' => $success]);
    }
}


