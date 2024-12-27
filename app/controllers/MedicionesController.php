<?php
class MedicionesController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleAction($action) {
        ob_start(); // Captura cualquier salida no deseada

        switch ($action) {
            case 'registrarMedicion':
                $this->registrarMedicionAction();
                break;
            case 'obtenerMediciones':
                $this->obtenerMedicionesAction();
                break;
            default:
                $this->sendHttpResponse(400, ['success' => false, 'message' => 'Acción no reconocida.']);
                break;
        }
    }

    private function registrarMedicionAction() {
        ob_end_clean(); // Limpia cualquier salida no deseada
        $idMedidor = $_POST['id_medidor'] ?? null;
        $idCliente = $_POST['id_cliente'] ?? null;
        $fechaLectura = $_POST['fecha_lectura'] ?? null;
        $lectura = $_POST['lectura_actual'] ?? null;

        if (!$idMedidor || !$idCliente || !$fechaLectura || !$lectura) {
            $this->sendHttpResponse(400, ['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        }

        $response = $this->registrarMedicion($idMedidor, $idCliente, $fechaLectura, $lectura);

        if ($response['success']) {
            $this->sendHttpResponse(200, ['success' => true, 'message' => 'Medición registrada con éxito.']);
        } else {
            $this->sendHttpResponse(500, ['success' => false, 'message' => 'Error al registrar la medición.']);
        }
    }

    private function obtenerMedicionesAction() {
        ob_end_clean(); // Limpia cualquier salida no deseada

        try {
            $mediciones = $this->model->obtenerMediciones();
            $this->sendHttpResponse(200, ['success' => true, 'data' => $mediciones]);
        } catch (Exception $e) {
            $this->sendHttpResponse(500, ['success' => false, 'message' => 'Error al obtener mediciones.']);
        }
    }

    public function registrarMedicion($idMedidor, $idCliente, $fechaLectura, $lectura) {
        try {
            $result = $this->model->registrarMedicion($idMedidor, $idCliente, $fechaLectura, $lectura);
            return $result
                ? ['success' => true]
                : ['success' => false];
        } catch (Exception $e) {
            return ['success' => false];
        }
    }

    private function sendHttpResponse($statusCode, $response) {
        ob_end_clean(); // Limpia el buffer de salida
        http_response_code($statusCode); // Establece el código HTTP
        header('Content-Type: application/json'); // Configura la respuesta como JSON
        echo json_encode($response);
        exit();
    }
}
?>
