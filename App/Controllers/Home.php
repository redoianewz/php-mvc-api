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
        $userIdValue = intval($userId['id'] ?? null);
        if ($userIdValue === 0) {                   
        $user = $model->getUserById($userIdValue);
        if ($user) {
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
        } else {
            $this->response->setResponse(404, 'User not found');
        }
        } else {
            $this->response->setResponse(400, 'Invalid user ID');
        }
    }


    public function createUser()
    {
        $model = $this->model('home');
        $errors = [];
        $fields = [
            'name' => ['string', 'Name'],
            'family' => ['string', 'Family'],
            'age' => ['integer', 'Age'],
            'country' => ['string', 'Country'],
            'city' => ['string', 'City']
        ];

        foreach ($fields as $field => [$expectedType, $fieldName]) {
            $value = $this->request->input($field);
            $error = $this->request->validateField($value, $expectedType, $fieldName);
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
            'name' => htmlspecialchars($this->request->input('name')),
            'family' => htmlspecialchars($this->request->input('family')),
            'age' => intval($this->request->input('age')),
            'country' => htmlspecialchars($this->request->input('country')),
            'city' => htmlspecialchars($this->request->input('city'))
        ];

        $model->insertUser($userData);
        $this->response->setResponse(200, 'User created successfully', $userData);
    }



    public function updateUser($userId)
    {       
        $model = $this->model('home');             
        $errors = [];
        $fields = [
            'name' => ['string', 'Name'],
            'family' => ['string', 'Family'],
            'age' => ['integer', 'Age'],
            'country' => ['string', 'Country'],
            'city' => ['string', 'City']
        ];
        foreach ($fields as $field => [$expectedType, $fieldName]) {
            $value = $this->request->input($field);
            $error = $this->request->validateField($value, $expectedType, $fieldName);
            if ($error !== null) {
                $errors[] = $error;
            }
        }
        $userIdValue = intval($userId['id'] ?? null);
        $userData = [
                'name' => htmlspecialchars($this->request->input('name')),
                'family' => htmlspecialchars($this->request->input('family')),
                'age' => intval($this->request->input('age')),
                'country' => htmlspecialchars($this->request->input('country')),
                'city' => htmlspecialchars($this->request->input('city'))
            ];
        if (!$userIdValue === 0) { 
            $user = $model->getUserById($userIdValue); 
            if ($user) { 
                if (!empty($errors)) {
                $this->response->sendStatus(400);
                $this->response->setContent(['errors' => $errors]);
                return;
                }           
                $model->updateUser($userIdValue, $userData);
                $this->response->setResponse(200, 'User updated successfully', $userData);
            } else {
                $this->response->setResponse(404, 'User not found');
            }
        } else {
            $this->response->setResponse(400, 'Invalid user ID');
        }
    }
    public function deleteUser($userId)
    {
        // Connect to the model
        $model = $this->model('home');
        $userIdValue = intval($userId['id'] ?? null);
        if ($userIdValue === 0) {          
        $user = $model->getUserById($userIdValue);
        if ($user) {
            $success = $model->deleteUser(intval($userId['id']));
            if ($success) {
                $this->response->setResponse(200, 'User deleted successfully');
            } else {
                $this->response->setResponse(500, 'Failed to delete user');
            }
        } else {
            $this->response->setResponse(404, 'User not found');
        }
        } else {
            $this->response->setResponse(400, 'Invalid user ID');
        }
    }
}
