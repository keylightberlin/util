<?php
namespace KeylightUtilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        return new JsonResponse(
            $this->get('keylight_util_health_check_provider')->getHealthCheckAsArray()
        );
    }
}
