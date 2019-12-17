<?php

namespace App\Http\Middleware;

use Closure;
use \Graze\GuzzleHttp\JsonRpc\Client;
use \Graze\GuzzleHttp\JsonRpc\Exception\RequestException;
use \Illuminate\Support\Facades\Log;

class AuthMiddleware
{

    protected $header = 'authorization';
    protected $prefix = 'bearer';
    protected $key = 'token';

    public function handle($request, Closure $next)
    {
        $token = $this->getToken($request);
        if (!$token) {
            return response(['code' => 401, 'message' => 'Unauthorized.'], 401);
        }
        $client = Client::factory(config('service.user_center'), ['rpc_error' => true]);
        $path = '/' . config('app.name') . '/' . $request->path() . '/' . $request->getMethod();
        $path = strtolower($path);
        $req = $client->request(1, '/user/checkToken', ['token' => $token, 'permission' => [$path]]);
        try {
            $user = $client->send($req)->getRpcResult();
            $request->user = $user;
        } catch (\Exception $e) {
            if ($e instanceof RequestException) {
                return response(['code' => 401, 'message' => $e->getResponse()->getRpcErrorMessage()], 401);
            } else {
                Log::error('user_center service error', ['message' => $e->getMessage()]); //如果是请求错误，记录日志
                return response(['code' => 401, 'message' => 'Unauthorized.'], 401);
            }
        }
        return $next($request);
    }

    protected function getToken($request)
    {
        $token = $this->getHeaderToken($request); //先从header获取token
        !$token && $token = $request->input($this->key); //从请求参数获取token
        return $token;
    }

    protected function getHeaderToken($request)
    {
        $header = $request->headers->get($this->header) ?: ($request->server->get('HTTP_AUTHORIZATION') ?: $request->server->get('REDIRECT_HTTP_AUTHORIZATION'));
        if ($header && preg_match('/' . $this->prefix . '\s*(\S+)\b/i', $header, $matches)) {
            return $matches[1];
        }
    }

}
