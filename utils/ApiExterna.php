<?php

class ApiExterna
{
    protected $baseUrl;
    protected $timeout;

    public function __construct()
    {
        $this->baseUrl = 'http://localhost:8000/api/public';
        $this->timeout = 10;
    }

    /**
     * Obtener lista de productos de la API externa
     */
    public function getProductos($page = 1, $perPage = 50, $search = null, $categoriaId = null)
    {
        $url = $this->baseUrl . '/productos?page=' . $page . '&per_page=' . $perPage;

        if ($search) {
            $url .= '&search=' . urlencode($search);
        }

        if ($categoriaId) {
            $url .= '&categoria_id=' . $categoriaId;
        }

        return $this->makeRequest($url);
    }

    /**
     * Obtener un producto específico
     */
    public function getProducto($id)
    {
        $url = $this->baseUrl . '/productos/' . $id;
        return $this->makeRequest($url);
    }

    /**
     * Realizar una solicitud HTTP GET
     */
    private function makeRequest($url)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                return [
                    'success' => false,
                    'message' => 'Error de conexión: ' . $error,
                    'data' => null
                ];
            }

            $data = json_decode($response, true);

            if ($httpCode !== 200) {
                return [
                    'success' => false,
                    'message' => $data['message'] ?? 'Error en la solicitud',
                    'data' => null
                ];
            }

            return $data;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Excepción: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
}
