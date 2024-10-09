<?php

namespace Ledc\HanLian;

/**
 * 汉连跨境HTTP请求客户端
 * - 处理签名逻辑
 */
class HttpClient
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * 构造函数
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * 请求之前回调
     * @param string $url
     * @param array $data
     * @return void
     */
    protected function eventRequestBefore(string &$url, array &$data)
    {
        $url = $this->joinUrl($url);
        $url = $this->signature($url);
    }

    /**
     * 拼接接口地址前缀，返回完整的URL
     * @param string $url
     * @return string
     */
    protected function joinUrl(string $url): string
    {
        return rtrim($this->getConfig()->api_host, '/') . '/' . ltrim($url, '/');
    }

    /**
     * 对请求签名
     * @param string $url
     * @return string
     */
    protected function signature(string $url): string
    {
        $timestamp = time();
        $urlInfo = parse_url($url);
        $port = empty($urlInfo['port']) ? '' : ':' . $urlInfo['port'];
        $plaintext = strtolower(implode('', [
            'post',
            $urlInfo['scheme'] . '://' . $urlInfo['host'] . $port,
            $urlInfo['path'],
            $this->getConfig()->app_secret,
            (string)$timestamp,
        ]));
        $signature = strtoupper(md5($plaintext));
        return $url . '?appKey=' . $this->getConfig()->app_key . '&sign=' . $signature . '&timestamp=' . $timestamp;
    }

    /**
     * POST请求（自动处理签名逻辑）
     * @param string $url
     * @param array $data
     * @return HttpResponse
     */
    public function postRequest(string $url, array $data): HttpResponse
    {
        // 请求之前回调
        $this->eventRequestBefore($url, $data);
        //var_dump('【请求】汉连跨境接口：' . $url, $data);
        //Log::notice(['【请求】汉连跨境接口：' . $url, $data]);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json; charset=utf-8",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0 Ledc/7.0",
            //"accept-encoding: gzip,deflate",
        ]);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

        $result = curl_exec($curl);
        $response = new HttpResponse($result, (int)curl_getinfo($curl, CURLINFO_RESPONSE_CODE), curl_errno($curl), curl_error($curl));
        // 请求之后回调
        $this->eventRequestAfter($url, $data, $response);
        //var_dump('【响应】汉连跨境接口：' . $url, $response->jsonSerialize());
        //Log::notice(['【响应】汉连跨境接口：' . $url, $response->jsonSerialize()]);
        curl_close($curl);

        return $response;
    }

    /**
     * 请求之后回调
     * @param string $url
     * @param array $data
     * @param HttpResponse $response
     * @return void
     */
    protected function eventRequestAfter(string $url, array $data, HttpResponse $response)
    {
    }
}
