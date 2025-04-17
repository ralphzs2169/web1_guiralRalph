<?php

class Router {
    // Dispatch the request based on URI and HTTP method
    public function dispatch($uri, $method) {
        echo "URI: $uri, Method: $method\n"; 

        // Load the database connection
        require_once __DIR__ . '/../config/database.php';

        $routes = $this->getRoutes();

        if (!isset($routes[$method])) {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        foreach ($routes[$method] as $route => $handler) {
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                list($controllerName, $action) = explode('@', $handler);

                require_once __DIR__ . '/../controllers/' . $controllerName . '.php';

                
                $controller = new $controllerName($pdo);

                if (method_exists($controller, $action)) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    if ($method === 'POST') {
                        $controller->$action($data, ...$matches);
                    } else {
                        $controller->$action(...$matches);
                    }
                    return;
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Method not found']);
                    return;
                }
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    // All routes are declared here
    private function getRoutes() {
        return [
            'POST' => [
                '/register' => 'RegisterController@register',
                '/updatePasscode' => 'RegisterController@updatePasscode',
                '/login' => 'LoginController@login',
                '/verify' => 'PasscodeController@verify',
                '/assignBed' => 'BedController@assignBedToPatient',
                '/removeBedAssignment' => 'BedController@removeBedAssignment',
                '/addPatient' => 'PatientController@create',
                '/updatePatient/{id}' => 'PatientController@update',
                '/addNote' => 'EndorsementController@create',
                '/addView/{user_id}/{patient_id}' => 'EndorsementViewController@addView',
                '/addAttachment' => 'AttachmentController@add',
                '/addReferral' => 'ReferralController@add',
                '/addTreatment' => 'TreatmentController@add',
                '/addIVF' => 'IvfInfusionController@add',
            ],
            'GET' => [
                '/departments' => 'DepartmentController@getDepartments',
                '/departments/{id}' => 'DepartmentController@getDepartment',
                '/allBeds' => 'BedController@getAllBeds',
                '/bed/{bed_number}' => 'BedController@getBedByNumber',
                '/patients/{id}' => 'PatientController@getPatientById',
                '/latestViewers/{patient_id}' => 'EndorsementViewController@getLatestViewers',
                '/attachments/{patient_id}' => 'AttachmentController@getByPatient',
                '/referrals/{patient_id}' => 'ReferralController@getByPatient',
                '/treatments/{patient_id}' => 'TreatmentController@getByPatient',
                '/ivf/{patient_id}' => 'IvfInfusionController@getByPatient',
                '/getNotes/{user_id}/{patient_id}' => 'EndorsementController@getNotes',
            ],
        ];
    }
}
