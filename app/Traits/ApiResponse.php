<?php


namespace App\Traits;


trait ApiResponse
{
    protected $code = 0;

    protected $status = 'success';

    protected $message = '';

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode(int $code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array $data
     * @param string|null $status
     * @param int|null $code
     * @return array
     */
    private function respond(array $data = [], string $status=null, int $code = null)
    {
        if ($code) {
            $this->setCode($code);
        }
        if ($status) {
            $this->setStatus($status);
        }
        $result = [
            'status' => $this->getStatus(),
            'code' => $this->getCode(),
        ];
        if ($this->message) {
            $result['message'] = $this->getMessage();
        }
        if (!empty($data)) {
            $result['data'] = $data;
        }
        return $result;
    }

    /**
     * @param string $message
     * @param int $code
     * @return array
     */
    public function error(string $message, int $code)
    {
        if ($code === 0) {
            $code = -1;
        }

        return $this->setStatus('error')->setCode($code)->setMessage($message)->respond();
    }

    /**
     * @param array $data
     * @return array
     */
    public function success(array $data = [])
    {
        return $this->respond($data);
    }

}
