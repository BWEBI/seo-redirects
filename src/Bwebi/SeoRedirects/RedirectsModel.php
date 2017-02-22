<?php

namespace Bwebi\SeoRedirects;

class RedirectsModel extends ValidModel
{
    protected $table = 'redirections';

    protected static $rules = [
        'from_url'      => 'required|url',
        'to_url'        => 'required|url',
        'status_code'   => 'numeric|in:301,302'
    ];

    protected static $messages = [
        'from_url.required'     => 'The parameter --> :attribute <-- is required',
        'from_url.url'          => 'The parameter --> :attribute <-- must be a valid, full url',
        'to_url.required'       => 'The parameter --> :attribute <-- is required',
        'to_url.url'            => 'The parameter --> :attribute <-- must be a valid, full url',
        'status_code.numeric'   => 'The parameter --> :attribute <-- must be numeric (e.g 301)',
        'status_code.in'        => 'The parameter --> :attribute <-- must be one of the following codes: :values'
    ];

    public static function encodeUrlPath($url)
    {
        return preg_replace_callback('#://([^/]+)/([^?]+)#', function ($match) {
            return '://' . $match[1] . '/' . implode('/', array_map('rawurlencode', explode('/', $match[2])));
        }, $url);
    }
}