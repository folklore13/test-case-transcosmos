<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Exception;

class AuthenticateWithJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return new JsonResponse(['message' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return new JsonResponse(['message' => 'Token invalid'], 401);
        } catch (JWTException $e) {
            return new JsonResponse(['message' => 'Token missing'], 401);
        } catch (Exception $e) {
            return new JsonResponse(['message' => 'Authentication error'], 401);
        }

        return $next($request);
    }
}
