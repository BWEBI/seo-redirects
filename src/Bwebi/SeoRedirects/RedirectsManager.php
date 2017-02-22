<?php

namespace Bwebi\SeoRedirects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedirectsManager
{
    public $request;
    public $redirect;

    /**
     * RedirectsManager constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array|bool
     */
    public function shouldBeRedirected()
    {
        $result = $this->findRequest($this->request);
        if (!is_null($result)) {
            return ['redirect_to' => $result->to_url, 'status_code' => $this->getRedirectStatusCode($result->status_code)];
        } else {
            return false;
        }
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function findRequest($request)
    {
        try {
            $this->redirect = DB::table('redirections')->where('from_url', $request->getRequestUri())->first();

            return $this->redirect;
        } catch (\Exception $ex) {
            Sentry::captureException($ex);
        }
    }

    /**
     * @param $status_code
     *
     * @return int
     */
    public function getRedirectStatusCode($status_code)
    {
        if (!is_null($status_code) && !empty($status_code)) {
            return $status_code;
        } else {
            return 301;
        }
    }
}