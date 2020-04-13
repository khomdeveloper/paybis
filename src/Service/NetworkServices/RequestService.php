<?php


namespace App\Service\NetworkServices;


class RequestService
{

    public function call(array $request)
    {
        try {
            $ch = curl_init();
            curl_setopt_array($ch, $request);
            $content = curl_exec($ch);
            $error = curl_error($ch);
            if (!empty($error)) {
                throw new RequestServiceException($error);
            }
            return $content;
        } catch (\Exception $e) {
            throw $e;
        } finally {
            curl_close($ch);
        }
    }

}