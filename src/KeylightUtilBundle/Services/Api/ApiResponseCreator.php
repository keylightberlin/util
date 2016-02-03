<?php
namespace KeylightUtilBundle\Services\Api;

use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerInterface;

class ApiResponseCreator
{
    const STANDARD_RESPONSE_FORMAT = 'json';

    const KEY_STATUS = 'status';
    const KEY_DATA = 'data';
    const KEY_ERRORS = 'errors';

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     * @param string|null|array $serializationLevel
     * @return Response
     */
    public function createResponse(array $data, $serializationLevel = null)
    {
        $responseData = [
            static::KEY_STATUS => static::STATUS_SUCCESS,
            static::KEY_DATA => $data
        ];

        $serializedData = $this->serializer->serialize(
            $responseData,
            self::STANDARD_RESPONSE_FORMAT,
            $serializationLevel ? SerializationContext::create()->setGroups($serializationLevel) : SerializationContext::create()
        );

        $response = $this->getJsonResponse($serializedData);

        return $response;
    }

    /**
     * @param array $errors
     * @param int $statusCode
     * @return Response
     */
    public function createErrorResponse(array $errors, $statusCode = 500)
    {
        $responseData = [
            static::KEY_STATUS => static::STATUS_ERROR,
            static::KEY_ERRORS => $errors
        ];

        $errorResponse = $this->getJsonResponse(json_encode($responseData));
        $errorResponse->setStatusCode($statusCode);

        return $errorResponse;
    }

    /**
     * @param string $content
     * @return Response
     */
    private function getJsonResponse($content)
    {
        $response = new Response($content);
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
