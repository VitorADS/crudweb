<?php

namespace App\Http;

class Response{

    /**
     * @var integer
     */
    private $httpCode = 200;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * @var mixed
     */
    private $content;

    /**
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct(int $httpCode, mixed $content, string $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * 
     */
    private function sendHeaders()
    {
        http_response_code($this->httpCode);

        foreach($this->headers as $key => $value){
            header($key . ': ' . $value);
        }
    }

    /**
     * 
     */
    public function sendResponse()
    {
        $this->sendHeaders();
        switch($this->contentType){
            case 'text/html':
                echo $this->content;
                break;
            case 'application/json':
                echo json_encode($this->content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                break;
        }
    }
}