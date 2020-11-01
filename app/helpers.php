<?php

if (!function_exists('flash')) {
    /**
     * Add a message and its type to the session
     * 
     * @param  string $messsage
     * @param  string $type
     * @return void
     */
    function flash(string $message, string $type = 'success'): void
    {
        session()->flash('message', $message);
        session()->flash('type', $type);
    }
}

if (!function_exists('clearString')) {
    /**
     * Remove extra characters from the string
     *
     * @param string $string
     * @return string
     */
    function clearString(string $string): string
    {
        return htmlspecialchars(trim($string));
    }
}

if (!function_exists('getCorrectUrl')) {
    /**
     * Remove the extra slash and add the domain if necessary
     *
     * @param string $url
     * @param string $favicon
     * @return string
     */
    function getCorrectUrl(string $url, string $favicon): string
    {
        $hasDomain = stripos($favicon, parse_url($url, PHP_URL_HOST));

        if ($hasDomain === false) {
            $domain = parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);
            return $domain . $favicon;
        }

        return $favicon;
    }
}
