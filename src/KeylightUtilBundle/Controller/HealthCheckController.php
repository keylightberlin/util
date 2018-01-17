<?php
namespace KeylightUtilBundle\Controller;

use KeylightUtilBundle\Model\Health\HealthCheck;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class HealthCheckController extends Controller
{
    /**
     * @Route("/_health", name="keylight_util_health_check")
     *
     * @return JsonResponse
     */
    public function healthCheckAction()
    {
        /** @var HealthCheck $results */
        $results = $this->get('keylight_util_health_check_provider')->getHealthCheck();
        return new JsonResponse(
            $results->toArray(),
            ($results->hasFailed()) ? Response::HTTP_SERVICE_UNAVAILABLE : Response::HTTP_OK
        );
    }
}
