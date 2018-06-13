<?php namespace TourChannel\Parks\Service;

use TourChannel\Parks\Enum\HttpEnum;

/**
 * Class Authentication
 * @package Tourchannel\Parks\Service
 */
class Authentication
{
    /**
     * Chave no GLOBLAL onde fica a configuração
     * @var string
     */
    const GLOBAL_KEY = "TOUCHANNEL_API_PARQUES";

    /**
     * Dados de configuração
     * @var
     */
    static protected $CONFIG;

    /**
     * Path da URL de requisição
     */
    const _PATH = '/authentication';

    /**
     * Recupera o token de autenticação no Cache
     * Caso não tenha gera um novo token e coloca no cache
     * @return mixed
     * @throws \Exception
     */
    static public function getToken()
    {
        // Config user
        self::$CONFIG = $GLOBALS[self::GLOBAL_KEY];

        // Recupera o token no cache
        $token_cache = self::verifyTokenCache();

        // Gera um novo token
        if(is_null($token_cache)) {
            return self::getNewToken();
        }

        // Caso não tenha o token gera um novo token
        return $token_cache;
    }

    /**
     * Retorna o token no cache e cria o arquivo de cache
     * @return mixed|null
     */
    static private function verifyTokenCache()
    {
        // Verifica se existe o arquivo
        if(file_exists(self::$CONFIG['file_cache_token'])) {

            // Recupera os dados do arquivo
            $file_cache = json_decode(file_get_contents(self::$CONFIG['file_cache_token']));

            // Verifica se tem token no cache
            if($file_cache->token != "" && $file_cache->expiration != "") {

                // Valida o token de acesso
                $is_valid = strtotime($file_cache->expiration) > time();

                // Se o tem ainda está valido
                if($is_valid) return $file_cache->token;
            }
        }

        // Null caso não passe pelas validações
        return null;
    }

    /**
     * Gera um novo token e coloca no cache
     * @return mixed
     */
    static private function getNewToken()
    {
        // Token devolvido pela API
        $token_access = self::authenticate();

        // Tempo para expirar o token -1 hora do que retornado na API
        $expires_at = strtotime($token_access->credentials->expiration) - 60 * 60;

        // Coloca o token em cache
        self::writeCacheFileToken([
            'token' => $token_access->credentials->token,
            'expiration' => date('Y-m-d H:i:s', $expires_at)
        ]);

        return $token_access->credentials->token;
    }

    /**
     * Comunicação com a API para gerar novo Token
     * @return mixed|string
     */
    private static function authenticate() {

        // Connect da API de pagamentos
        $request_connect = new RequestConnect();

        // Realiza a comunicação
        return $request_connect->authenticate_api(self::_PATH, HttpEnum::METHOD_POST, [
            'user' => self::$CONFIG['user'],
            'password' => self::$CONFIG['password'],
        ]);
    }

    /**
     * Atualiza ou cria o arquivo de cache
     * @param array $data
     */
    static private function writeCacheFileToken(array $data = [])
    {
        // Caso seja para criar o arquivo inicia com dados vazio
        if(sizeof($data) == 0) {
            $data = [ 'token' => "", 'expiration' => "" ];
        }

        // Cria o arquivo ou atualiza
        file_put_contents(self::$CONFIG['file_cache_token'], json_encode($data));
    }
}