<?php
namespace KeylightUtilBundle\Services\Response;

use Symfony\Component\HttpFoundation\Response;

class ResponseProvider
{
    /**
     * @param string $data
     * @param string $filename
     * @return Response
     */
    public function getCsvResponse($data, $filename)
    {
        $response = new Response($data);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
